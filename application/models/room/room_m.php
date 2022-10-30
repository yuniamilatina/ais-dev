<?php

class room_m extends CI_Model {

    private $table_reservation = 'GAF.TT_ROOM_RESERVATION';    
    private $table_room = 'GAF.TM_ROOM';

    function __construct() {
        parent::__construct();
    }
    
    function get_all_room(){
        return $this->db->query("SELECT * FROM $this->table_room WHERE INT_FLG_DEL = 1")->result();
    }
    
    function get_data_room($id) {
        $query = $this->db->query("SELECT RTRIM(CHR_KODE_ROOM) CHR_KODE_ROOM, RTRIM(CHR_DESC) CHR_DESC, RTRIM(CHR_URL_DISPLAY) CHR_URL_DISPLAY FROM $this->table_room where CHR_KODE_ROOM = '$id'");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    
    function save($data) {
        $this->db->insert($this->table_room, $data);
    }
    
    function delete($id) {
        $data = array('INT_FLG_DEL' => 0);
        $this->db->where('CHR_KODE_ROOM', $id);
        $this->db->update($this->table_room, $data);
    }

    function update($data, $id) {
        $this->db->where('CHR_KODE_ROOM', $id);
        $this->db->update($this->table_room, $data);
    }

    function get_name_room_by_id($roomid){
         $query = $this->db->query("SELECT CHR_DESC FROM  $this->table_room
                                    WHERE CHR_KODE_ROOM = '$roomid'");
        if ($query->num_rows() > 0) {
            $room_name = $query->row();
            return $room_name->CHR_DESC;
        } else {
            return 'N/A';
        }
    }
    
    function get_event($date, $hour, $roomid) {
        $query = $this->db->query("SELECT TOP 1 R.CHR_DESC, RR.CHR_MEETING_DESC, RR.CHR_MEETING_DEPT, 
                                    RR.CHR_DATE_FROM, RR.CHR_DATE_TO, RR.CHR_TIME_FROM, RR.CHR_TIME_TO
                                    FROM  $this->table_reservation RR 
                                    INNER JOIN $this->table_room R ON R.CHR_KODE_ROOM = RR.CHR_KODE_ROOM
                                    WHERE RR.CHR_DATE_FROM = '$date' AND R.CHR_KODE_ROOM = '$roomid'
                                    AND ( '$hour' >= RR.CHR_TIME_FROM  AND '$hour' <= RR.CHR_TIME_TO) and RR.BIT_FLG_DEL = 1");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function get_next_event($date, $hour, $roomid) {
        $query = $this->db->query("SELECT TOP 1 R.CHR_DESC, RR.CHR_MEETING_DESC, RR.CHR_MEETING_DEPT, RR.CHR_DATE_FROM, RR.CHR_DATE_TO,
                                            RR.CHR_TIME_FROM, RR.CHR_TIME_TO
                                    FROM $this->table_reservation RR 
                                    INNER JOIN $this->table_room R ON R.CHR_KODE_ROOM = RR.CHR_KODE_ROOM
                                    WHERE RR.CHR_DATE_FROM = '$date' AND R.CHR_KODE_ROOM = '$roomid'
                                    AND RR.CHR_TIME_FROM > '$hour'  and RR.BIT_FLG_DEL = 1
                                    order by RR.CHR_TIME_FROM");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function get_next_event_table($date, $hour, $roomid) {
        $query = $this->db->query("SELECT TOP 5 R.CHR_DESC, RR.CHR_MEETING_DESC, RR.CHR_MEETING_DEPT, RR.CHR_DATE_FROM, RR.CHR_DATE_TO,
                                            RR.CHR_TIME_FROM, RR.CHR_TIME_TO ,RR.CHR_MEETING_PIC ,RR.CHR_MEETING_DEPT
                                    FROM  $this->table_reservation RR 
                                    INNER JOIN $this->table_room R ON R.CHR_KODE_ROOM = RR.CHR_KODE_ROOM
                                    WHERE RR.CHR_DATE_FROM = '$date' AND R.CHR_KODE_ROOM = '$roomid'
                                    AND RR.CHR_TIME_FROM > '$hour' and RR.BIT_FLG_DEL = 1 
                                    order by RR.CHR_TIME_FROM");

        return $query->result();
    }

}
