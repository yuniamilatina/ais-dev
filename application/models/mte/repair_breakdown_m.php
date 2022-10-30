<?php
	class repair_breakdown_m extends CI_Model
	{
		
		private $tabel = 'MTE.TT_REPAIR_BREAKDOWN';
		private $tabel_detail = 'MTE.TT_REPAIR_BREAKDOWN_DETAIL';

		function save($data) {
	        $this->db->insert($this->tabel, $data);
			$insert_id = $this->db->insert_id();
			return  $insert_id;
	    }

		function saveDetail($data) {
	        $this->db->insert($this->tabel_detail, $data);
			$insert_id = $this->db->insert_id();
			return  $insert_id;
	    }

	}
