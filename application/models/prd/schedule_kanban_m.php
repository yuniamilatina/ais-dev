<?php

class schedule_kanban_m extends CI_Model {

    private $tabel = 'PRD.TT_SCHEDULE_KANBAN';

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
        $created_by = $this->session->userdata('USERNAME');
        $data = array('INT_FLG_DEL' => 1, 
            'INT_SEQUENCE' => 0, 
            'CHR_MODIFIED_BY' => $created_by,
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His'));

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_schedule_kanban() {
        $sql = "SELECT INT_ID,INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE, INT_FLG_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0";

        return $this->db->query($sql)->result();
    }

    function get_detail_schedule_kanban_by_id($id) {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, CHR_DATE, INT_FLG_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }
   
    function get_data_schedule_kanban_by_period($period, $work_center, $status){
    //    $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->tabel 
    //        WHERE INT_FLG_DEL = 0 AND LEFT(CHR_DATE,6) = '$period' AND CHR_WORK_CENTER = '$work_center'";

	$sql = "SELECT A.INT_ID, A.INT_SEQUENCE, A.CHR_WORK_CENTER, A.CHR_PART_NO, A.INT_LOT_SIZE, A.CHR_DATE , 
                    B.CHR_BACK_NO , A.INT_QTY_PER_BOX, A.INT_QTY_PCS, A.INT_FLG_SO, A.INT_FLG_PRD
                        FROM PRD.TT_SCHEDULE_KANBAN AS A
			INNER JOIN 
			TM_KANBAN AS B
			ON
			A.CHR_PART_NO = B.CHR_PART_NO
			WHERE A.INT_FLG_DEL = 0 AND LEFT(A.CHR_DATE,6) = '$period' AND A.CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '$status' AND B.CHR_KANBAN_TYPE = '5' ORDER BY INT_SEQUENCE";
        return $this->db->query($sql)->result();
    }

    function get_data_schedule_kanban_by_period_new($period, $work_center, $status){
        
        $sql = "SELECT A.INT_ID, A.INT_SEQUENCE, A.CHR_WORK_CENTER, A.CHR_PART_NO, A.INT_LOT_SIZE, A.CHR_DATE , 
                        B.CHR_BACK_NO , A.INT_QTY_PER_BOX, A.INT_QTY_PCS, A.INT_FLG_SO, A.INT_FLG_PRD
                            FROM PRD.TT_SCHEDULE_KANBAN AS A
                INNER JOIN (SELECT DISTINCT CHR_BACK_NO, RTRIM(CHR_PART_NO) AS CHR_PART_NO FROM 
                TM_KANBAN WHERE CHR_KANBAN_TYPE IN ('1','5')) AS B
                ON A.CHR_PART_NO = B.CHR_PART_NO
                WHERE A.INT_FLG_DEL = 0 AND LEFT(A.CHR_DATE,6) = '$period' AND A.CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '$status' ORDER BY INT_SEQUENCE";
        return $this->db->query($sql)->result();
    }

    // function get_remaining_count_by_seq($date, $work_center, $seq){
    //     $query = $this->db->query("SELECT COUNT(INT_ID) AS REMAINING FROM $this->tabel 
    //         WHERE INT_FLG_DEL = 0 AND CHR_DATE = '$date' AND CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE > $seq AND INT_SEQUENCE <> $seq")->row();

    //     return $query->REMAINING;
    // }

    function get_remaining_count_by_seq($old_seq, $new_seq, $date, $work_center ){
        $stored_procedure = "EXEC PRD.zsp_get_sequence_schedule_kanban ?, ?, ?, ?";
        $param = array(
            'seq_old' => $old_seq,
            'seq_new' => $new_seq,
            'date' => $date,
            'work_center' => $work_center
            );
        
        $query = $this->db->query($stored_procedure, $param);

        return $query->num_rows();
    }

    function get_data_remaining_by_seq($old_seq, $new_seq, $date, $work_center ){
        $stored_procedure = "EXEC PRD.zsp_get_sequence_schedule_kanban ?, ?, ?, ?";
        $param = array(
            'seq_old' => $old_seq,
            'seq_new' => $new_seq,
            'date' => $date,
            'work_center' => $work_center
            );
        
        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_by_sequence($date, $work_center, $id){
        $sql = "SELECT TOP 1 * FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND CHR_DATE = '$date' AND CHR_WORK_CENTER = '$work_center' AND INT_ID = $id";

        return $this->db->query($sql)->row();
    }
    
    function get_data_detail_part($part_no){
        $query =  $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' AND CHR_KANBAN_TYPE = '5'");
        
        if($query->num_rows() > 0){
            return $query->row()->INT_QTY_PER_BOX;
        }else{
            return 0;
        }
    }

    function get_data_detail_part_new($part_no){
        $query =  $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' AND CHR_KANBAN_TYPE IN ('1','5') ORDER BY CHR_KANBAN_TYPE DESC");
        
        if($query->num_rows() > 0){
            return $query->row()->INT_QTY_PER_BOX;
        }else{
            return 0;
        }
    }

}
