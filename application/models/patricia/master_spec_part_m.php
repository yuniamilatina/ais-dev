<?php

/**
 * 
 */
class master_spec_part_m extends CI_Model
{

	private $tabel = 'PRD.TM_PARAMETER_CEK_PART';
	private $tbl_spec = 'PRD.TM_DATA_SPEC_PART';
	private $tbl_ukur = 'PRD.TM_DATA_UKUR_PART';

	function get_data_ukur_by_line($work_center)
	{
		$sql = "SELECT a.CHR_LINE,a.CHR_POS,c.CHR_PARAMETER,b.* 
					FROM $this->tbl_spec a inner join $this->tbl_ukur b on a.CHR_ID_SPEC=b.CHR_ID_SPEC
					inner join $this->tabel c on c.CHR_ID_PARAM=a.CHR_ID_PARAM
					WHERE a.CHR_LINE = '$work_center'
					ORDER BY a.CHR_LINE ASC, b.CHR_PARTNO ASC,a.CHR_POS ASC";
		return $this->db->query($sql)->result();
	}

	function get_data_group($group)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d = $mrp_d->query("SELECT * FROM TM_GROUP_FG where CHR_GROUP='$group' ORDER BY CHR_GROUP ASC");
		return $mrp_d->result();
	}

	function get_line_param()
	{
		$query = $this->db->query("select a.CHR_ID_SPEC,a.CHR_LINE,a.CHR_POS,b.CHR_PARAMETER from PRD.TM_DATA_SPEC_PART a inner join PRD.TM_PARAMETER_CEK_PART b 
										on a.CHR_ID_PARAM=b.CHR_ID_PARAM where a.CHR_FLAG_STATUS='F' order by a.CHR_LINE asc, a.CHR_POS asc");
		return $query->result();
	}

	function get_part_assy()
	{
		$query = $this->db->query("select distinct CHR_PART_NO,CHR_BACK_NO from TM_KANBAN where CHR_KANBAN_TYPE='5' and (CHR_FLAG_DELETE <>'X' or CHR_FLAG_DELETE is null)");
		return $query->result();
	}

	function get_all_part()
	{
		$query = $this->db->query("select distinct CHR_PART_NO,CHR_BACK_NO from TM_KANBAN where (CHR_KANBAN_TYPE='5' or CHR_KANBAN_TYPE='1' or CHR_KANBAN_TYPE='0') and (CHR_FLAG_DELETE <>'X' or CHR_FLAG_DELETE is null) order by CHR_BACK_NO asc");
		return $query->result();
	}

	function save_dtukur($data)
	{
		$this->db->insert($this->tbl_ukur, $data);
	}

	function get_spec_id($id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_GROUP_FG WHERE INT_ID = '$id'")->row();
	}

	function get_routing($part)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d = $mrp_d->query("SELECT distinct a.*,b.CHR_BACK_NO FROM DB_MRP_DEV.dbo.TM_ROUTING_MRP a inner join DB_AIS.dbo.TM_KANBAN b
								on b.CHR_PART_NO=a.CHR_PART_NO where a.CHR_PART_NO='$part' order by a.CHR_PV asc");
		return $mrp_d->result();
	}

	function get_params_cek()
	{
		$query = $this->db->query("select CHR_ID_PARAM,CHR_PARAMETER from $this->tabel where CHR_FLAG_STATUS = 'F'");
		return $query->result();
	}

	function get_line_prd()
	{
		$query = $this->db->query("SELECT distinct CHR_WCENTER,INT_DEPT FROM TM_DIRECT_BACKFLUSH_GENERAL ORDER BY CHR_WCENTER ASC");
		return $query->result();
	}

	function save_param($data_pr)
	{
		$this->db->insert($this->tabel, $data_pr);
	}

	function check_cpty($line)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$query = $mrp_d->query("SELECT TOP 1 * FROM TM_CAPACITY_MRP WHERE CHR_WORK_CENTER = '$line'");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function save_capacity($data_pr)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->insert('TM_CAPACITY_MRP', $data_pr);
	}

	function get_route_id($partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_ROUTING_MRP WHERE CHR_PART_NO = '$partno' and CHR_PV='$pv'")->row();
	}

	function del_routing($partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$session = $this->session->all_userdata();
		$data = array(
			'CHR_MAIN_STATUS' => 'X',
			'CHR_UPDATE_BY' => $session['NPK'],
			'CHR_UPDATE_TIME' => date('His'),
			'CHR_UPDATE_DATE' => date('Ymd')
		);

		$mrp_d->where('CHR_PART_NO', $partno);
		$mrp_d->where('CHR_PV', $pv);
		$mrp_d->update('TM_ROUTING_MRP', $data);
	}

	function aktif_route($partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$session = $this->session->all_userdata();
		$data = array(
			'CHR_MAIN_STATUS' => 'T',
			'CHR_UPDATE_BY' => $session['NPK'],
			'CHR_UPDATE_TIME' => date('His'),
			'CHR_UPDATE_DATE' => date('Ymd')
		);

		$mrp_d->where('CHR_PART_NO', $partno);
		$mrp_d->where('CHR_PV', $pv);
		$mrp_d->update('TM_ROUTING_MRP', $data);
	}

	function get_line_id($id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_CAPACITY_MRP WHERE INT_ID = '$id'")->row();
	}

	function update_route($data, $partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('CHR_PART_NO', $partno);
		$mrp_d->where('CHR_PV', $pv);
		$mrp_d->update('TM_ROUTING_MRP', $data);
	}

	function all_part()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$sql = "SELECT distinct CHR_PART_NO 
					FROM TM_ROUTING_MRP";
		return $mrp_d->query($sql)->result();
	}

	function get_data_capacity()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$sql = "SELECT * 
					FROM TM_CAPACITY_MRP";
		return $mrp_d->query($sql)->result();
	}

	function update_cap($data, $id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('INT_ID', $id);
		$mrp_d->update('TM_CAPACITY_MRP', $data);
	}

	function update_groupfg($data, $id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('INT_ID', $id);
		$mrp_d->update('TM_GROUP_FG', $data);
	}
}
