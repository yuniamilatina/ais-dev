<?php

class elina_schedule_m extends CI_Model {

    private $tabel = 'PRD.TM_ELINA_SCHEDULE';
    private $temp_tabel = 'PRD.TW_PART_PER_LINE';

    public function __construct() {
        parent::__construct();
    }
    
    function select_data() {
        $data =  $this->db->query("SELECT * FROM $this->tabel order by CHR_AREA asc, CHR_TIME_EXEC asc")->result();
        return $data;
    }

    function save() {
        
        $stored_procedure = "EXEC PRD.zsp_merge_part_per_line";
        
        $this->db->query($stored_procedure);
    }

    
    function get_data_target_by_workcenter_and_period($work_center, $period){
        $status = $this->db->query("SELECT INT_TARGET_PER_SHIFT FROM PRD.TM_TARGET_PRODUCTION WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PERIOD = '$period'");
        
        if ($status->num_rows() > 0) {
            return $status->row()->INT_TARGET_PER_SHIFT;
        } else {
            return 0;
        }
    }
    
    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        // $this->db->where('CHR_BACK_NO', $bno);
        $this->db->update($this->tabel, $data);
    }

    function get_data_by_id($id) {
        return $this->db->query("SELECT * FROM $this->tabel WHERE INT_ID = '$id'")->row();
    }

    function get_data($date) {
        $data =  $this->db->query("SELECT * FROM $this->tabel WHERE CHR_PERIOD = '$date' AND INT_FLG_DEL = 0")->result();
        return $data;
    }

    function get_data_temp() {
        return $this->db->query("SELECT * FROM $this->temp_tabel WHERE CHR_FLAG_STATUS = 'F'")->result();
    }

    function get_status_data_temp() {
        $status = $this->db->query("SELECT * FROM $this->temp_tabel");

        if ($status->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function save_temp($data) {
        $this->db->insert($this->temp_tabel, $data);
    }

    function truncate_temp_data() {
        $this->db->query("truncate table $this->temp_tabel");
    }
    
    function get_all_partno() {
        return $query = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='0' ORDER BY CHR_PART_NO ASC")->result();
    }
    
    function get_all_backno() {
        return $query = $this->db->query("SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='0' ORDER BY CHR_BACK_NO ASC")->result();
    }
    
    function save_dt($data) {
        $this->db->insert($this->tabel, $data);

    }
    
    function select_data_part_by($sloc) {
        $this->db->select("* FROM PRD.TM_ELINA_SCHEDULE");
        $this->db->where("CHR_FLAG_DELETE='F'");
        $this->db->where_in('CHR_AREA', $sloc);
        $query = $this->db->get();
        return $query->result();
    }

}
