<?php

class room_reservation_m extends CI_Model {

    private $table_reservation = 'GAF.TT_ROOM_RESERVATION';    
    private $table_room = 'GAF.TM_ROOM';

    function __construct() {
        parent::__construct();
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
                                    FROM  $this->table_reservation RR 
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

    function get_all_reservation_by_date() {
        $query = $this->db->query("SELECT RR.INT_FLG_GENBA, RR.INT_FLG_MEETING, RR.INT_FLG_CONFERENCE, RR.CHR_ID_RESERV, R.CHR_DESC, RR.CHR_MEETING_DESC, RR.CHR_MEETING_DEPT, RR.CHR_DATE_FROM, RR.CHR_DATE_TO,
                                            RR.CHR_TIME_FROM, RR.CHR_TIME_TO
                                    FROM  $this->table_reservation RR 
                                    INNER JOIN $this->table_room R ON R.CHR_KODE_ROOM = RR.CHR_KODE_ROOM
                                    WHERE BIT_FLG_DEL = 1
                                    order by RR.CHR_DATE_FROM DESC, RR.CHR_TIME_FROM");
        return $query->result();
    }

    function save_reservation($data) {
        $this->db->insert($this->table_reservation, $data);
    }

//    function generate_id_reservation() {
//        return $this->db->query('select max(CHR_ID_RESERV) as a from $this->table_reservation')->row()->a + 1;
//    }

    function get_data_reservation($id) {
        $query = $this->db->query("SELECT RR.INT_FLG_MEETING, RR.INT_FLG_GENBA, RR.INT_FLG_CONFERENCE, 
                                RR.CHR_ID_RESERV, R.CHR_DESC, RR.CHR_MEETING_DESC, RR.CHR_MEETING_DEPT, RR.CHR_DATE_FROM, RR.CHR_DATE_TO,
                                RR.CHR_AGENDA, RR.CHR_TIME_FROM, RR.CHR_TIME_TO, RR.CHR_MEETING_PIC, RR.CHR_MEETING_DEPT
                                    FROM  $this->table_reservation RR 
                                    INNER JOIN $this->table_room R ON R.CHR_KODE_ROOM = RR.CHR_KODE_ROOM
                                    WHERE RR.CHR_ID_RESERV = '$id' 
                                    order by RR.CHR_TIME_FROM");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 0);

        $this->db->where('CHR_ID_RESERV', $id);
        $this->db->update($this->table_reservation, $data);
    }

    function update($data, $id) {
        $this->db->where('CHR_ID_RESERV', $id);
        $this->db->update($this->table_reservation, $data);
    }
    
    function cek_available_room($room_id, $start_date, $start_time, $finish_date, $finish_time){
        $query = $this->db->query("select top 1 1 from $this->table_reservation where CHR_KODE_ROOM = '$room_id' 
                                        and CHR_DATE_FROM = '$start_date' and '$start_time' >= CHR_TIME_FROM and '$start_time' < CHR_TIME_TO
                                        and '$finish_time' < CHR_TIME_FROM and '$finish_time' >= CHR_TIME_TO
                                        ");

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

}
