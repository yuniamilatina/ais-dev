<?php

class line_stop_m extends CI_Model {

    private $tabel = 'TT_LINE_STOP_PROD';
    private $tabel_master = 'TM_LINE_STOP';

    public function __construct() {
        parent::__construct();
    }

//2017-09-12
    function get_data_line_stop($codels) {
        $data_ls = $this->db->query("SELECT CHR_LINE_STOP FROM $this->tabel_master WHERE CHR_LINE_CODE = '$codels'");

        return trim($data_ls->row()->CHR_LINE_STOP);
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    // function geCountLS($wo) {
    //     return $this->db->query("SELECT SUM(INT_DURASI_LS) as INT_TOTAL_LINE_STOP FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo'");
    // }

//     function start_line_stop($wo, $work_center, $shift, $dateprod, $codels) {
//         $date = date('Ymd');
//         $time = date('His');
//         $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//         $data = $this->db->query("SELECT TOP 1 INT_NUMBER, CHR_IP FROM TT_PRODUCTION_RESULT
//                 WHERE CHR_WO_NUMBER = '$wo' 
//                 AND CHR_IP = '$ip'
//                 AND CHR_STATUS_MOBILE = 'I' 
//                 ORDER BY INT_NUMBER DESC");

//         if ($data->num_rows() > 0) {
//             $int_number = $data->row()->INT_NUMBER;
//         } else {
//             $int_number = '';
//         }

//         $this->db->query("INSERT INTO TT_LINE_STOP_PROD (CHR_LINE_CODE, INT_NUMBER, CHR_WO_NUMBER, CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_START_DATE, CHR_START_TIME)
//                 VALUES ('$codels', '$int_number' , '$wo', '$work_center', '$dateprod', '$shift', '$date', '$time', '$date', '$time')");

//         $db_display = $this->get_db_display($work_center);

//         $db_display->query("INSERT INTO `tt_losttime` 
//                 (`INT_ID_LOSTTIME`, `CHR_DATE`, `CHR_SHIFT`, `CHR_WO_NUMBER`)
//                 VALUES ('$codels', '$date', '$shift', '$wo')");

//         $db_display->query("UPDATE disp_ops_master SET int_flg_linestop = 1, int_id_losstime = '$codels'");

//         return true;
//     }

    // function stop_line_stop($work_center) {
    //     $db_display = $this->get_db_display($work_center);

    //     $db_display->query("UPDATE disp_ops_master SET int_flg_linestop = 0, int_id_losstime = 'N/A'");
    // }

//20170825
    // function need_help_mte($wo, $codels, $work_center) {
    //     $db_display = $this->get_db_display($work_center);
    //     $time = date('His');

    //     $db_display->query("UPDATE `tt_losttime` SET INT_FLG_FOLLOWUP = 1 , CHR_LS_WAIT = '$time' 
    //     WHERE `CHR_WO_NUMBER`='$wo' AND `INT_ID_LOSTTIME`='$codels' ORDER BY INT_ID DESC LIMIT 1"); //
    // }

//20170822
    // function start_follow_up($wo, $codels, $work_center, $npk) {

    //     $data_user = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'");
    //     if ($data_user->num_rows() > 0) {
    //         $username = trim($data_user->row()->CHR_USERNAME);
    //     } else {
    //         $username = $npk;
    //     }

    //     $db_display = $this->get_db_display($work_center);

    //     $db_display->query("UPDATE `tt_losttime` SET INT_FLG_FOLLOWUP = 2, CHR_NPK = '$npk', CHR_USERNAME = '$username' 
    //     WHERE `CHR_WO_NUMBER`='$wo' AND `INT_ID_LOSTTIME`='$codels' ORDER BY INT_ID DESC LIMIT 1"); //ORDER BY INT_ID DESC LIMIT 1
    // }

//20170822
    // function stop_follow_up($wo, $codels, $work_center) {
    //     $db_display = $this->get_db_display($work_center);

    //     $db_display->query("UPDATE `tt_losttime` SET INT_FLG_FOLLOWUP = 0 WHERE `CHR_WO_NUMBER`='$wo' AND `INT_ID_LOSTTIME`='$codels' ORDER BY INT_ID DESC LIMIT 1");
    // }

// //20170822
//     function geCountFollowup($wo) {
//         $array_error = $this->db->query("SELECT ISNULL(SUM(INT_DURASI_REPAIR),0) AS INT_TOTAL_DURASI_REPAIR FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");

//         if ($array_error->num_rows() > 0) {
//             return $array_error->row_array();
//         } else {
//             return 0;
//         }
//     }

//20170826
    // function geCountWaiting($wo) {
    //     $array_error = $this->db->query("SELECT ISNULL(SUM(INT_DURASI_WAITING),0) AS INT_TOTAL_DURASI_WAITIING FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");

    //     if ($array_error->num_rows() > 0) {
    //         return $array_error->row_array();
    //     } else {
    //         return 0;
    //     }
    // }

//20170822
    // function getLineStopMachine($wo, $codels) {
    //     $array_error = $this->db->query("SELECT TOP 1 * FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER =  '$wo' AND CHR_LINE_CODE =  '$codels' ORDER BY INT_ID_LINE_STOP DESC");

    //     if ($array_error->num_rows() > 0) {
    //         return $array_error->row_array();
    //     } else {
    //         return 0;
    //     }
    // }

//20170822
    // function update_total_line_stop_machine($total, $wo) {
    //     $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_TOTAL_DURASI_REPAIR = '$total'
    //             WHERE CHR_WO_NUMBER = '$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");
    // }

//20170826
    // function update_total_waiting_machine($total, $wo) {
    //     $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_TOTAL_DURASI_WAITIING = '$total'
    //             WHERE CHR_WO_NUMBER = '$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");
    // }

    function get_data_summary_line_stop($wo){
        $stored_procedure = "EXEC PRD.zsp_get_history_line_stop_ines ?";
        $param = array(
            'wo' => $wo
        );
        return $this->db->query($stored_procedure, $param)->row();
    }

    function get_all_line_stop($w_center, $date, $shift) {
        $query = $this->db->query("SELECT TM_LINE_STOP.* , ISNULL(TT_LINE_STOP_PROD.INT_DURASI_LS , '0') AS TIME
            FROM  TM_LINE_STOP
            LEFT JOIN TT_LINE_STOP_PROD ON TM_LINE_STOP.CHR_LINE_CODE = TT_LINE_STOP_PROD.CHR_LINE_CODE and
            TT_LINE_STOP_PROD.CHR_WORK_CENTER = '$w_center' AND  TT_LINE_STOP_PROD.CHR_DATE = '$date' AND TT_LINE_STOP_PROD.CHR_SHIFT =  '$shift'");

        return $query->result();
    }
    
    //add display connection base on work center
    // function get_db_display($work_center) {
    //     if ($work_center == 'ASCC01') {
    //         $db_display = $this->load->database('ASCC01', TRUE);
    //     } 
    //     else if ($work_center == 'ASCC02') {
    //         $db_display = $this->load->database('ASCC02', TRUE);
    //     } 
    //     else if ($work_center == 'ASCC03') {
    //         $db_display = $this->load->database('ASCC03', TRUE);
    //     } 
    //     else if ($work_center == 'ASCC04') {
    //         $db_display = $this->load->database('ASCC04', TRUE);
    //     } 
    //     else if ($work_center == 'ASCD01') {
    //         $db_display = $this->load->database('ASCD01', TRUE);
    //     } 
    //     else if ($work_center == 'ASCD02') {
    //         $db_display = $this->load->database('ASCD02', TRUE);
    //     } 
    //     else if ($work_center == 'ASCD03') {
    //         $db_display = $this->load->database('ASCD03', TRUE);
    //     } 
    //     else if ($work_center == 'ASCH01') {
    //        $db_display = $this->load->database('ASCH01', TRUE);
    //     }
    //     else if ($work_center == 'ASDL01') {
    //         $db_display = $this->load->database('ASDL01', TRUE);
    //     } else if ($work_center == 'ASDL02') {
    //         $db_display = $this->load->database('ASDL02', TRUE);
    //     } 
    //     else if ($work_center == 'ASDL03') {
    //         $db_display = $this->load->database('ASDL03', TRUE);
    //     } 
    //     else if ($work_center == 'ASDL04') {
    //         $db_display = $this->load->database('ASDL04', TRUE);
    //     }
    //     else if ($work_center == 'ASDL05') {
    //         $db_display = $this->load->database('ASDL05', TRUE);
    //     }
    //     else if ($work_center == 'ASDL07') {
    //         $db_display = $this->load->database('ASDL07', TRUE);
    //     }
    //     else if ($work_center == 'ASDL08') {
    //         $db_display = $this->load->database('ASDL08', TRUE);
    //     } 
    //     else if ($work_center == 'ASDL09') {
    //         $db_display = $this->load->database('ASDL09',TRUE);
    //         $connected = $db_display->initialize();
    //         if (!$connected) 
    //         {
    //             $db_display = $this->load->database('display',TRUE);
    //         }
    //     } 
    //     else if ($work_center == 'ASDL10') {
    //         $db_display = $this->load->database('ASDL10', TRUE);
    //     } 
    //     else if ($work_center == 'ASIM01') {
    //         $db_display = $this->load->database('ASIM01', TRUE);
    //     } else if ($work_center == 'ASIM02') {
    //         $db_display = $this->load->database('ASIM02', TRUE);
    //     } 
    //     else if ($work_center == 'ASIM03') {
    //         $db_display = $this->load->database('ASIM03', TRUE);
    //     } 
    //     else if ($work_center == 'ASDH01') {
    //         $db_display = $this->load->database('ASDH01', TRUE);
    //     } 
    //     else if ($work_center == 'ASDH02') {
    //         $db_display = $this->load->database('ASDH02', TRUE);
    //     } 
    //     else if ($work_center == 'ASHL01') {
    //         $db_display = $this->load->database('ASHL01', TRUE);
    //     } else if ($work_center == 'ASHL02') {
    //         $db_display = $this->load->database('ASHL02', TRUE);
    //     } else if ($work_center == 'ASCA01') {
    //         $db_display = $this->load->database('ASCA01', TRUE);
    //     } 
    //     else if ($work_center == 'ASCA02') {
    //         $db_display = $this->load->database('ASCA02', TRUE);
    //     } 
    //     else if ($work_center == 'ASRH01') {
    //         $db_display = $this->load->database('ASRH01', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF01') {
    //         $db_display = $this->load->database('ASDF01', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF02') {
    //         $db_display = $this->load->database('ASDF02', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF03') {
    //         $db_display = $this->load->database('ASDF03', TRUE);
    //     }
    //      else if ($work_center == 'ASDF04') {
    //         $db_display = $this->load->database('ASDF04', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF05') {
    //         $db_display = $this->load->database('ASDF05', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF06') {
    //         $db_display = $this->load->database('ASDF06', TRUE);
    //     } else if ($work_center == 'ASDF07') {
    //         $db_display = $this->load->database('ASDF07', TRUE);
    //     } else if ($work_center == 'ASDF08') {
    //         $db_display = $this->load->database('ASDF08', TRUE);
    //     } else if ($work_center == 'ASDF09') {
    //         $db_display = $this->load->database('ASDF09', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF10') {
    //         $db_display = $this->load->database('ASDF10', TRUE);
    //     } 
    //     else if ($work_center == 'ASDF11') {
    //         $db_display = $this->load->database('ASDF11', TRUE);
    //     } 
    //     else if ($work_center == 'ASIM04') {
    //         $db_display = $this->load->database('ASIM04', TRUE);
    //     } 
    //     else if ($work_center == 'ASDL12') {
    //         $db_display = $this->load->database('ASDL12', TRUE);
    //     } else if ($work_center == 'ASDL13') {
    //         $db_display = $this->load->database('ASDL13', TRUE);
    //     } else if ($work_center == 'PC003A') {
    //         $db_display = $this->load->database('PC003A', TRUE);
    //     } else if ($work_center == 'PC003B') {
    //         $db_display = $this->load->database('PC003B', TRUE);
    //     } else if ($work_center == 'PC003C') {
    //         $db_display = $this->load->database('PC003C', TRUE);
    //     } else if ($work_center == 'PC003D') {
    //         $db_display = $this->load->database('PC003D', TRUE);
    //     } else if ($work_center == 'PC003E') {
    //         $db_display = $this->load->database('PC003E', TRUE);
    //     } 
    //     else if ($work_center == 'PC003F') {
    //         $db_display = $this->load->database('PC003F', TRUE);
    //     } 
    //     else if ($work_center == 'PC003G') {
    //         $db_display = $this->load->database('PC003G', TRUE);
    //     } else if ($work_center == 'PC003I') {
    //         $db_display = $this->load->database('PC003I', TRUE);
    //     } 
    //     else if ($work_center == 'PC001A') {
    //         $db_display = $this->load->database('PC001A', TRUE);
    //     } else if ($work_center == 'PC001B') {
    //         $db_display = $this->load->database('PC001B', TRUE);
    //     } 
    //     else if ($work_center == 'PC001C') {
    //         $db_display = $this->load->database('PC001C', TRUE);
    //     } 
    //     else if ($work_center == 'PC001D') {
    //         $db_display = $this->load->database('PC001D', TRUE);
    //     } 
    //     else if ($work_center == 'PK0002') {
    //         $db_display = $this->load->database('PK0002', TRUE);
    //     } 
    //     else if ($work_center == 'PR001A') {
    //         $db_display = $this->load->database('PR001A', TRUE);
    //     } else if ($work_center == 'PR001B') {
    //         $db_display = $this->load->database('PR001B', TRUE);
    //     } else if ($work_center == 'PR002A') {
    //         $db_display = $this->load->database('PR002A', TRUE);
    //     } else if ($work_center == 'PR002B') {
    //         $db_display = $this->load->database('PR002B', TRUE);
    //     } else if ($work_center == 'PR002C') {
    //         $db_display = $this->load->database('PR002C', TRUE);
    //     } 
    //     else if ($work_center == 'PR002D') {
    //         $db_display = $this->load->database('PR002D', TRUE);
    //     } 
    //     else if ($work_center == 'PR002E') {
    //         $db_display = $this->load->database('PR002E', TRUE);
    //     } 
    //     else if ($work_center == 'PR003A') {
    //         $db_display = $this->load->database('PR003A', TRUE);
    //     } else if ($work_center == 'PR003B') {
    //         $db_display = $this->load->database('PR003B', TRUE);
    //     } else if ($work_center == 'PR003C') {
    //         $db_display = $this->load->database('PR003C', TRUE);
    //     } 
    //     else if ($work_center == 'PR005B') {
    //         $db_display = $this->load->database('PR005B', TRUE);
    //     } else if ($work_center == 'PR004C') {
    //         $db_display = $this->load->database('PR004C', TRUE);
    //     } 
    //     else if ($work_center == 'PR006Q') {
    //         $db_display = $this->load->database('PR006Q', TRUE);
    //     } 
    //     else if ($work_center == 'PR006I') {
    //         $db_display = $this->load->database('PR006I', TRUE);
    //     } 
    //     else if ($work_center == 'PR007C') {
    //         $db_display = $this->load->database('PR007C', TRUE);
    //     } 
    //     else if ($work_center == 'PR008B') {
    //         $db_display = $this->load->database('PR008B', TRUE);
    //     } 
    //     else if ($work_center == 'PR009B') {
    //         $db_display = $this->load->database('PR009B', TRUE);
    //     } 
    //     else {
    //         $db_display = $this->load->database('display', TRUE);
    //     }

    //     return $db_display;
    // }

}
