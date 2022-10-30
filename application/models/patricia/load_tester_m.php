<?php

	class load_tester_m extends CI_Model
	{
		private $tabel = 'QUA.TT_LOAD_TESTER';

		public function __construct() {
			parent::__construct();
		}

		function save($data) {
			$this->db->insert($this->tabel, $data);
		}

		function update($data, $id) {
			$this->db->where($id);
			$this->db->update($this->tabel, $data);
		}

		function delete($id) {
			$data = array('INT_FLG_DEL' => 1);

			$this->db->where('INT_ID', $id);
			$this->db->update($this->tabel, $data);
		}

		function get_data(){
			return $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0")->result();
		}
		
		function get_data_by_date($period){
			return $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0 AND LEFT(CHR_TEST_DATE,6) = '$period'")->result();
			
		}

	}
?>