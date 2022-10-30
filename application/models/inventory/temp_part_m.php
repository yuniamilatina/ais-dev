<?php

class temp_part_m extends CI_Model {

	private $tabel1 = 'TT_TEMP_PART';

	public function __construct() {
        parent::__construct();
    }

    function get_data_temp() {
        $data =  $this->db->query("SELECT * FROM $this->tabel1")->result();
        return $data;
    }

    function save_temp($data_tr) {
        $this->db->insert($this->tabel1, $data_tr);
    }

    function get_data_phantom_parts($work_center) {
        $sql = $this->db->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_WORK_CENTER, B.CHR_BACK_NO, C.CHR_PART_NAME
                FROM TM_PHANTOM A
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$work_center' AND A.INT_FLG_DEL = 0
                ORDER BY A.CHR_PART_NO");
        return $sql->result();
    }

    function get_back_no_by_part_no($part_no) {
        $sql = "SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN
            WHERE CHR_PART_NO = '$part_no'";

        return $this->db->query($sql)->row();
    }

    function insert_phantom_part($data) {
        $this->db->insert('TM_PHANTOM', $data);
    }

    public function get_data_part_by_work_center($work_center){
        return $this->db->query("SELECT P.CHR_PART_NO FROM TM_PARTS P INNER JOIN TM_PROCESS_PARTS PP
        ON P.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_WORK_CENTER = '$work_center'
        WHERE P.CHR_PART_NO NOT IN (SELECT RTRIM(CHR_PART_NO) AS CHR_PART_NO FROM TM_PHANTOM WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0')
        GROUP BY P.CHR_PART_NO")->result();
    }

    function update_flag_delete_phantom_part($id, $date, $time, $user) {
        $sql = $this->db->query("UPDATE TM_PHANTOM SET INT_FLG_DEL = '1', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    public function get_work_center_phantom_elina($id_dept){
        return $this->db->query("SELECT * FROM PRD.TM_WORK_CENTER_PHANTOM_ELINA WHERE INT_ID_DEPT = '$id_dept'")->result();
    }

    function update_phantom_work_center($id, $data) {
        $this->db->where('INT_ID', $id);
        $this->db->update('PRD.TM_WORK_CENTER_PHANTOM_ELINA', $data);
    }

    function insert_phantom_work_center($data) {
        $this->db->insert('PRD.TM_WORK_CENTER_PHANTOM_ELINA', $data);
    }

    public function check_data_phantom_work_center($work_center){
        return $this->db->query("SELECT * FROM PRD.TM_WORK_CENTER_PHANTOM_ELINA WHERE CHR_WORK_CENTER = '$work_center'");
    }

}