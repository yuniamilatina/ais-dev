<?php

class master_part_line_m extends CI_Model {

    private $tabel = 'TM_MAIN_WORK_CENTER';
//    private $temp_tabel = 'PRD.TW_PART_PER_LINE';

    public function __construct() {
        parent::__construct();
    }
    
    function select_data_part() {
        $this->db->select("distinct A.CHR_PART_NO,C.CHR_PART_NAME,B.CHR_BACK_NO,B.INT_QTY_PER_BOX,A.CHR_WORK_CENTER,A.CHR_MAIN_STAT 
                            FROM TM_MAIN_WORK_CENTER A 
                            INNER JOIN TM_KANBAN B 
                            ON A.CHR_PART_NO = B.CHR_PART_NO  
                            INNER JOIN TM_PARTS C
                            ON C.CHR_PART_NO = A.CHR_PART_NO");
        $this->db->where("B.CHR_KANBAN_TYPE='5'");
        $query = $this->db->get();
        return $query->result();
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

    function update($data, $pno,$wcr) {
        $this->db->where('CHR_PART_NO', $pno);
        $this->db->where('CHR_WORK_CENTER', $wcr);
        $this->db->update($this->tabel, $data);
    }

    function get_data_by_id($pno,$wcr) {
        return $this->db->query("SELECT a.*,b.CHR_BACK_NO FROM $this->tabel as a inner join TM_KANBAN as b on a.CHR_PART_NO = b.CHR_PART_NO "
                . "WHERE a.CHR_PART_NO = '$pno' AND a.CHR_WORK_CENTER='$wcr'")->row();
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

//        $feedback = $data['CHR_FEEDBACK'];
//        $created_date = $data['CHR_CREATED_DATE'];
//        $created_time = date('H:i:s');
//        $creator = strtoupper($data['CHR_CREATED_BY']);
//        $wo_no = $data['CHR_WO_NUMBER'];
//        $work_center = substr($wo_no, 0, 6);
//        $name = explode(" ", $creator);
//        
//        $db_display = $this->get_db_display($work_center);
//        
//        $db_display->query("INSERT INTO tt_comment 
//            (CHR_COMMENT, CHR_WO_NUMBER, CHR_USERNAME, CHR_CREATED_DATE, CHR_CREATED_TIME)
//            VALUES
//            ('$feedback', '$wo_no', '$name[0]', '$created_date', '$created_time' )");
    }
    
    function select_data_part_by($sloc) {
        $data =  $this->db->query("select distinct A.CHR_PART_NO,C.CHR_PART_NAME,B.CHR_BACK_NO,B.INT_QTY_PER_BOX,A.CHR_WORK_CENTER,A.CHR_MAIN_STAT 
                            FROM TM_MAIN_WORK_CENTER A 
                            INNER JOIN TM_KANBAN B 
                            ON A.CHR_PART_NO = B.CHR_PART_NO  
                            INNER JOIN TM_PARTS C
                            ON C.CHR_PART_NO = A.CHR_PART_NO 
                            where B.CHR_KANBAN_TYPE='5' and A.CHR_WORK_CENTER like '%$sloc%'")->result();
        return $data;
//        $this->db->select("1distinct A.CHR_PART_NO,C.CHR_PART_NAME,B.CHR_BACK_NO,B.INT_QTY_PER_BOX,A.CHR_WORK_CENTER,A.CHR_MAIN_STAT 
//                            FROM TM_MAIN_WORK_CENTER A 
//                            INNER JOIN TM_KANBAN B 
//                            ON A.CHR_PART_NO = B.CHR_PART_NO  
//                            INNER JOIN TM_PARTS C
//                            ON C.CHR_PART_NO = A.CHR_PART_NO");
//        $this->db->where("B.CHR_KANBAN_TYPE='5'");
//        $this->db->like('A.CHR_WORK_CENTER', $sloc);
//        $query = $this->db->get();
//        return $query->result();
    }

}
