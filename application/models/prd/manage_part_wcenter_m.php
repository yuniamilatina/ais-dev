<?php

class manage_part_wcenter_m extends CI_Model {

private $tabel = 'TM_PROCESS_PARTS';

    public function __construct() {
        parent::__construct();
    }
    
    function update($part_no, $wcenter, $status) {
        $this->db->query("UPDATE TM_PROCESS_PARTS SET CHR_FLAG_ACTIVE = '$status' WHERE CHR_PART_NO = '$part_no' AND CHR_WORK_CENTER = '$wcenter'");
    }

    function get_data_part_no($part_no, $back_no) {
        // if($part_no == '' && $back_no == ''){
        //     $sql = "SELECT DISTINCT TOP 200 A.CHR_PART_NO, C.CHR_PART_NAME, B.CHR_BACK_NO, A.CHR_WORK_CENTER, A.CHR_PV, A.CHR_FLAG_ACTIVE
        //         FROM TM_PROCESS_PARTS A
        //         LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
        //         LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
        //         WHERE A.CHR_PART_NO LIKE '$part_no%'
        //             AND B.CHR_BACK_NO LIKE '$back_no%'
        //             AND (A.CHR_FLAG_DELETE IS NULL OR A.CHR_FLAG_DELETE <> 1)";

        // } else {
            $sql = "SELECT A.CHR_PART_NO,  '' AS CHR_PART_NAME, 
            B.CHR_BACK_NO, A.CHR_WORK_CENTER, A.CHR_PV, A.CHR_FLAG_ACTIVE
                FROM TM_PROCESS_PARTS A
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                -- LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                WHERE  CAST(CHR_PV AS INT) < 11
                    AND A.CHR_PART_NO LIKE '$part_no%'
                    AND B.CHR_BACK_NO LIKE '$back_no%'
                    AND (A.CHR_FLAG_DELETE IS NULL OR A.CHR_FLAG_DELETE <> 1)
                GROUP BY A.CHR_PART_NO,   
            B.CHR_BACK_NO, A.CHR_WORK_CENTER, A.CHR_PV, A.CHR_FLAG_ACTIVE";
        // }        

        return $this->db->query($sql)->result();
    }
}
