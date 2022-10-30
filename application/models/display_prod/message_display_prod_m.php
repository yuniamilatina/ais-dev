<?php

class message_display_prod_m extends CI_Model {

    private $tabel = "TT_PRODUCTION_DISPLAY_MESSAGE";

    public function __construct() {
        parent::__construct();
    }

    function get_data_message($id_dept) {
        return $query = $this->db->query("SELECT * from TT_PRODUCTION_DISPLAY_MESSAGE WHERE INT_FLG_DEL = 0 AND INT_ID_DEPT = $id_dept AND CHR_CREATED_DATE =  CONVERT([VARCHAR](10),GETDATE(),(112))")->result();
    }

    //additional
    function get_all_work_center_by_dept($id_dept) {
        return $query = $this->db->query("SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN WHERE INT_ID_DEPT = $id_dept  AND CHR_WORK_CENTER <> 'OTHER' GROUP BY CHR_WORK_CENTER")->result();
    }

    function save($data) {
        $message = strtoupper($data['CHR_MESSAGE']);
        $created_date = $data['CHR_CREATED_DATE'];
        $created_time = date('H:i:s');
        $creator = strtoupper($data['CHR_CREATED_BY']);
        $target = $data['CHR_TARGET_SOLVE'];
        $wo_no = $data['CHR_WO_NUMBER'];
        $work_center = substr($wo_no, 0, 6);
        $shift = substr(trim($wo_no), -1);
        $date = substr(trim($wo_no), -15, 8);

        $this->db->insert($this->tabel, $data);

        $name = explode(" ", $creator);

        $db_display = $this->get_db_display($work_center);

        $db_display->query("UPDATE `disp_ops_master` SET `chr_message` = '$message', `chr_created_date_message` = '$created_date',
                `chr_created_time_message` = '$created_time', `chr_username` = '$name[0]'
                WHERE `chr_wcenter` = '$work_center'");
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 0);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);

        $message = strtoupper($data['CHR_MESSAGE']);
        //$target = $data['CHR_TARGET_SOLVE'];
        $wo_no = $data['CHR_WO_NUMBER'];
        $work_center = substr($wo_no, 0, 6);

        $db_display = $this->get_db_display($work_center);

        $db_display->query("UPDATE `disp_ops_master` SET `chr_message` = '$message' WHERE chr_doc_id = '$wo_no' ");
    }

    function get_data_message_by_id($id) {
        $query = $this->db->query("select * from TT_PRODUCTION_DISPLAY_MESSAGE WHERE INT_ID = $id");
        return $query;
    }

    //add display connection base on work center
    function get_db_display($work_center) {
        if ($work_center == 'ASCC01') {
            $db_display = $this->load->database('ASCC01', TRUE);
        } else
        if ($work_center == 'ASCC02') {
            $db_display = $this->load->database('ASCC02', TRUE);
        } else if ($work_center == 'ASCC03') {
            $db_display = $this->load->database('ASCC03', TRUE);
        } else if ($work_center == 'ASCC04') {
            $db_display = $this->load->database('ASCC04', TRUE);
        } else if ($work_center == 'ASCD01') {
            $db_display = $this->load->database('ASCD01', TRUE);
        } else if ($work_center == 'ASCD02') {
            $db_display = $this->load->database('ASCD02', TRUE);
        } else if ($work_center == 'ASCD03') {
            $db_display = $this->load->database('ASCD03', TRUE);
        } else if ($work_center == 'ASCH01') {
            $db_display = $this->load->database('ASCH01', TRUE);
        } else if ($work_center == 'ASDL01') {
            $db_display = $this->load->database('ASDL01', TRUE);
        } else if ($work_center == 'ASDL02') {
            $db_display = $this->load->database('ASDL02', TRUE);
        } else if ($work_center == 'ASDL03') {
            $db_display = $this->load->database('ASDL03', TRUE);
        } else if ($work_center == 'ASDL04') {
            $db_display = $this->load->database('ASDL04', TRUE);
        } else if ($work_center == 'ASDL05') {
            $db_display = $this->load->database('ASDL05', TRUE);
        } else if ($work_center == 'ASDL07') {
            $db_display = $this->load->database('ASDL07', TRUE);
        } else if ($work_center == 'ASDL08') {
            $db_display = $this->load->database('ASDL08', TRUE);
        } 
        else if ($work_center == 'ASDL09') {
            $db_display = $this->load->database('ASDL09', TRUE);
        } 
        else if ($work_center == 'ASDL10') {
            $db_display = $this->load->database('ASDL10', TRUE);
        } else if ($work_center == 'ASIM01') {
            $db_display = $this->load->database('ASIM01', TRUE);
        } else if ($work_center == 'ASIM02') {
            $db_display = $this->load->database('ASIM02', TRUE);
        } else if ($work_center == 'ASIM03') {
            $db_display = $this->load->database('ASIM03', TRUE);
        } else if ($work_center == 'ASDH01') {
            $db_display = $this->load->database('ASDH01', TRUE);
        } else if ($work_center == 'ASDH02') {
            $db_display = $this->load->database('ASDH02', TRUE);
        } else if ($work_center == 'ASHL01') {
            $db_display = $this->load->database('ASHL01', TRUE);
        } else if ($work_center == 'ASHL02') {
            $db_display = $this->load->database('ASHL02', TRUE);
        } else if ($work_center == 'ASCA01') {
            $db_display = $this->load->database('ASCA01', TRUE);
        } else if ($work_center == 'ASCA02') {
            $db_display = $this->load->database('ASCA02', TRUE);
        } else if ($work_center == 'ASRH01') {
            $db_display = $this->load->database('ASRH01', TRUE);
        } else if ($work_center == 'ASDF01') {
            $db_display = $this->load->database('ASDF01', TRUE);
        } else if ($work_center == 'ASDF02') {
            $db_display = $this->load->database('ASDF02', TRUE);
        } else if ($work_center == 'ASDF03') {
            $db_display = $this->load->database('ASDF03', TRUE);
        } else if ($work_center == 'ASDF04') {
            $db_display = $this->load->database('ASDF04', TRUE);
        } else if ($work_center == 'ASDF05') {
            $db_display = $this->load->database('ASDF05', TRUE);
        } else if ($work_center == 'ASDF06') {
            $db_display = $this->load->database('ASDF06', TRUE);
        } else if ($work_center == 'ASDF07') {
            $db_display = $this->load->database('ASDF07', TRUE);
        } else if ($work_center == 'ASDF08') {
            $db_display = $this->load->database('ASDF08', TRUE);
        } else if ($work_center == 'ASDF09') {
            $db_display = $this->load->database('ASDF09', TRUE);
        } else if ($work_center == 'ASDF10') {
            $db_display = $this->load->database('ASDF10', TRUE);
        } else if ($work_center == 'ASDF11') {
            $db_display = $this->load->database('ASDF11', TRUE);
        } 
        else if ($work_center == 'ASIM04') {
            $db_display = $this->load->database('ASIM04', TRUE);
        } 
        else if ($work_center == 'ASDL12') {
            $db_display = $this->load->database('ASDL12', TRUE);
        } else if ($work_center == 'ASDL13') {
            $db_display = $this->load->database('ASDL13', TRUE);
        } else if ($work_center == 'PC003A') {
            $db_display = $this->load->database('PC003A', TRUE);
        } else if ($work_center == 'PC003B') {
            $db_display = $this->load->database('PC003B', TRUE);
        } else if ($work_center == 'PC003C') {
            $db_display = $this->load->database('PC003C', TRUE);
        } else if ($work_center == 'PC003D') {
            $db_display = $this->load->database('PC003D', TRUE);
        } else if ($work_center == 'PC003E') {
            $db_display = $this->load->database('PC003E', TRUE);
        } else if ($work_center == 'PC003F') {
            $db_display = $this->load->database('PC003F', TRUE);
        } else if ($work_center == 'PC003G') {
            $db_display = $this->load->database('PC003G', TRUE);
        } else if ($work_center == 'PC003I') {
            $db_display = $this->load->database('PC003I', TRUE);
        } else if ($work_center == 'PC001A') {
            $db_display = $this->load->database('PC001A', TRUE);
        } else if ($work_center == 'PC001B') {
            $db_display = $this->load->database('PC001B', TRUE);
        } else if ($work_center == 'PC001C') {
            $db_display = $this->load->database('PC001C', TRUE);
        } else if ($work_center == 'PC001D') {
            $db_display = $this->load->database('PC001D', TRUE);
        } else if ($work_center == 'PK0002') {
            $db_display = $this->load->database('PK0002', TRUE);
        } else if ($work_center == 'PR001A') {
            $db_display = $this->load->database('PR001A', TRUE);
        } else if ($work_center == 'PR001B') {
            $db_display = $this->load->database('PR001B', TRUE);
        } else if ($work_center == 'PR002A') {
            $db_display = $this->load->database('PR002A', TRUE);
        } else if ($work_center == 'PR002B') {
            $db_display = $this->load->database('PR002B', TRUE);
        } else if ($work_center == 'PR002C') {
            $db_display = $this->load->database('PR002C', TRUE);
        } else if ($work_center == 'PR002D') {
            $db_display = $this->load->database('PR002D', TRUE);
        } else if ($work_center == 'PR002E') {
            $db_display = $this->load->database('PR002E', TRUE);
        } 
        // else if ($work_center == 'PR003A') {
        //     $db_display = $this->load->database('PR003A', TRUE);
        // } else if ($work_center == 'PR003B') {
        //     $db_display = $this->load->database('PR003B', TRUE);
        // } else if ($work_center == 'PR003C') {
        //     $db_display = $this->load->database('PR003C', TRUE);
        // } 
        else if ($work_center == 'PR005B') {
            $db_display = $this->load->database('PR005B', TRUE);
        } else if ($work_center == 'PR004C') {
            $db_display = $this->load->database('PR004C', TRUE);
        } else if ($work_center == 'PR006Q') {
            $db_display = $this->load->database('PR006Q', TRUE);
        } else if ($work_center == 'PR006I') {
            $db_display = $this->load->database('PR006I', TRUE);
        } else if ($work_center == 'PR007C') {
            $db_display = $this->load->database('PR007C', TRUE);
        } else if ($work_center == 'PR008B') {
            $db_display = $this->load->database('PR008B', TRUE);
        } else if ($work_center == 'PR009B') {
            $db_display = $this->load->database('PR009B', TRUE);
        } else {
            $db_display = $this->load->database('display', TRUE);
        }

        return $db_display;
    }

}
