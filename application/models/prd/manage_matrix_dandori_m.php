<?php

class manage_matrix_dandori_m extends CI_Model {

private $tabel = 'TM_PROCESS_PARTS';
private $tabel_special = 'PRD.TM_SPECIAL_PRINT_PARTS';

    public function __construct() {
        parent::__construct();
    }
    
    function update($part_no, $wcenter, $group) {
        $this->db->query("UPDATE TM_PARTS SET CHR_MATRIX_DANDORI = '$group' WHERE CHR_PART_NO LIKE '$part_no%'");
    }

    function get_data_part_no($work_center) {
        $sql = "SELECT DISTINCT A.CHR_PART_NO, C.CHR_PART_NAME, B.CHR_BACK_NO, B.CHR_RAKNO, B.CHR_KANBAN_TYPE, A.CHR_WORK_CENTER, A.CHR_PV, A.CHR_FLAG_ACTIVE, C.CHR_MATRIX_DANDORI
                FROM TM_PROCESS_PARTS A
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER LIKE '$work_center%'
                    AND B.CHR_KANBAN_TYPE IN ('5','6')
                    AND (A.CHR_FLAG_DELETE IS NULL OR A.CHR_FLAG_DELETE <> 1)";

        return $this->db->query($sql)->result();
    }

    function get_data_part_no_passthrough() {
        $sql = "SELECT DISTINCT C.CHR_PART_NO, C.CHR_PART_NAME, B.CHR_BACK_NO, B.CHR_RAKNO, B.CHR_KANBAN_TYPE, 'pass' AS CHR_WORK_CENTER, C.CHR_MATRIX_DANDORI
                FROM TM_PARTS C
                INNER JOIN TM_KANBAN B ON C.CHR_PART_NO = B.CHR_PART_NO
                WHERE B.CHR_WORK_CENTER IS NULL
                    AND B.CHR_KANBAN_TYPE IN ('6')
                    AND (C.CHR_FLAG_DELETE IS NULL OR C.CHR_FLAG_DELETE = '')";

        return $this->db->query($sql)->result();
    }

    function update_rack_no($part_no, $kbn_type, $rackno) {
        $this->db->query("UPDATE TM_KANBAN SET CHR_RAKNO = '$rackno' WHERE CHR_PART_NO = '$part_no' AND CHR_KANBAN_TYPE = '$kbn_type'");
    }

    function get_all_prod_dept() {
        $query = $this->db->query("select INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC from TM_DEPT WHERE INT_ID_DEPT IN (21,23,24)")->result();
        return $query;
    }

    function get_data_part_no_special_print($work_center) {
        $sql = "SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, C.CHR_PART_NAME, B.CHR_BACK_NO, A.CHR_WORK_CENTER, A.INT_FLG_DEL, D.CHR_IP, D.CHR_USAGE
                FROM PRD.TM_SPECIAL_PRINT_PARTS A
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_INLINE_SCAN D ON D.INT_ID = A.INT_ID_PRINTER
                WHERE A.CHR_WORK_CENTER = '$work_center'
                    AND B.CHR_KANBAN_TYPE IN ('5', '6')
                    AND B.CHR_FLAG_DELETE IS NULL
                    AND C.CHR_FLAG_DELETE IS NULL";

        return $this->db->query($sql)->result();
    }

    function get_data_part_no_special_print_by_id($id) {
        $sql = "SELECT *
                FROM PRD.TM_SPECIAL_PRINT_PARTS
                WHERE INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }

    function update_special_print_parts($id, $flag, $date, $time, $user){
        $this->db->query("UPDATE PRD.TM_SPECIAL_PRINT_PARTS
                    SET INT_FLG_DEL = '$flag',
                        CHR_MODIFIED_BY = '$user',
                        CHR_MODIFIED_DATE = '$date',
                        CHR_MODIFIED_TIME = '$time'
                WHERE INT_ID = '$id'");
    }

    function edit_special_print_parts($id, $id_printer, $date, $time, $user){
        $this->db->query("UPDATE PRD.TM_SPECIAL_PRINT_PARTS
                    SET INT_ID_PRINTER = '$id_printer',
                        CHR_MODIFIED_BY = '$user',
                        CHR_MODIFIED_DATE = '$date',
                        CHR_MODIFIED_TIME = '$time'
                WHERE INT_ID = '$id'");
    }

    function get_all_part_no($work_center) {
        $all_part_no = $this->db->query("SELECT DISTINCT A.CHR_PART_NO, A.CHR_PART_NAME, B.CHR_BACK_NO, C.CHR_WORK_CENTER
                        FROM TM_PARTS A
                        LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                        LEFT JOIN TM_PROCESS_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                        WHERE A.CHR_BACK_NO IS NOT NULL 
                            AND A.CHR_BACK_NO <> '' 
                            AND B.CHR_BACK_NO <> ''
                            --AND A.CHR_FLAG_DELETE <> '1'
                            AND B.CHR_KANBAN_TYPE IN ('5','6')
                            AND C.CHR_WORK_CENTER = '$work_center'
                            AND A.CHR_PART_NO NOT IN (SELECT CHR_PART_NO FROM PRD.TM_SPECIAL_PRINT_PARTS)
                        ORDER BY A.CHR_PART_NO")->result();
        return $all_part_no;
    }

    function get_all_printer($work_center) {
        $all_printer = $this->db->query("SELECT INT_ID, CHR_IP, CHR_USAGE
                        FROM TM_INLINE_SCAN
                        WHERE CHR_WORK_CENTER LIKE '$work_center%'
                            AND BIT_FLG_ACTIVE = '1'
                            AND CHR_USAGE LIKE '%Printer%'
                        ORDER BY CHR_IP")->result();
        return $all_printer;
    }

    function add_new_special_part($data){
        $this->db->insert($this->tabel_special, $data);
    }
}
