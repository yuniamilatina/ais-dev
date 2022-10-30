<?php

class room_meeting_display_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'room/room_reservation_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('room/room_m');
//        $this->load->model('portal/notification_m');
    }

    public function room($roomid = null) {
        $content = 'room/room_meeting_display_v';
        $data['title'] = "Room Display";

        $data['room'] = $this->room_m->get_name_room_by_id($roomid);
        $data['roomid'] = $roomid;

        $date = date('Ymd');
        $hour = date('His');

        $room = $this->room_m->get_event($date, $hour, $roomid);
        $next_room = $this->room_m->get_next_event($date, $hour, $roomid);
        $next_room_table = $this->room_m->get_next_event_table($date, $hour, $roomid);


        if ($room != 0) {
            $data['data_room_desc'] = $room['CHR_MEETING_DESC'];
            $data['data_room_date'] = date("jS F, Y", strtotime($room['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($room['CHR_TIME_FROM'])) . ' - ' . date("H:i", strtotime($room['CHR_TIME_TO']));
            if ($next_room != 0) {
                $data['data_room_next_reservation'] = $next_room['CHR_MEETING_DESC'];
                $data['date_room_next_reservation'] = date("jS F, Y", strtotime($next_room['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room['CHR_TIME_FROM']));
                $data['data_room_next_reservation_table'] = $next_room_table;
            } else {
                $data['data_room_next_reservation'] = 'No Reservation';
                $data['data_room_next_reservation_table'] = $next_room_table;
                $data['date_room_next_reservation'] = "";
            }
        } else {
            $data['data_room_desc'] = 'Available';
            $data['data_room_date'] = "";
            if ($next_room != 0) {
                $data['data_room_next_reservation'] = $next_room['CHR_MEETING_DESC'];
                $data['date_room_next_reservation'] = date("jS F, Y", strtotime($next_room['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room['CHR_TIME_FROM']));
                $data['data_room_next_reservation_table'] = $next_room_table;
            } else {
                $data['data_room_next_reservation'] = 'No Reservation';
                $data['data_room_next_reservation_table'] = $next_room_table;
                $data['date_room_next_reservation'] = "";
            }
        }
        $this->load->view($content, $data);
    }

    public function guestroom($roomid1 = null, $roomid2 = null) {
        $content = 'room/guestroom_meeting_display_v';
        $data['title'] = "Room Display";

        $data['room1'] = $this->room_m->get_name_room_by_id($roomid1);
        $data['room2'] = $this->room_m->get_name_room_by_id($roomid2);
        $data['roomid1'] = $roomid1;
        $data['roomid2'] = $roomid2;

        $date = date('Ymd');
        $hour = date('His');

        $room1 = $this->room_m->get_event($date, $hour, $roomid1);
        $next_room1 = $this->room_m->get_next_event($date, $hour, $roomid1);
        $next_room_table1 = $this->room_m->get_next_event_table($date, $hour, $roomid1);

        if ($room1 != 0) {
            $data['data_room_desc1'] = $room1['CHR_MEETING_DESC'];
            $data['data_room_date1'] = date("jS F, Y", strtotime($room1['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($room1['CHR_TIME_FROM'])) . ' - ' . date("H:i", strtotime($room1['CHR_TIME_TO']));
            if ($next_room1 != 0) {
                $data['data_room_next_reservation1'] = $next_room1['CHR_MEETING_DESC'];
                $data['date_room_next_reservation1'] = date("jS F, Y", strtotime($next_room1['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room1['CHR_TIME_FROM']));
                $data['data_room_next_reservation_table1'] = $next_room_table1;
            } else {
                $data['data_room_next_reservation1'] = 'No Reservation';
                $data['data_room_next_reservation_table1'] = $next_room_table1;
                $data['date_room_next_reservation1'] = "";
            }
        } else {
            $data['data_room_desc1'] = 'Available';
            $data['data_room_date1'] = "";
            if ($next_room1 != 0) {
                $data['data_room_next_reservation1'] = $next_room1['CHR_MEETING_DESC'];
                $data['date_room_next_reservation1'] = date("jS F, Y", strtotime($next_room1['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room1['CHR_TIME_FROM']));
                $data['data_room_next_reservation_table1'] = $next_room_table1;
            } else {
                $data['data_room_next_reservation1'] = 'No Reservation';
                $data['data_room_next_reservation_table1'] = $next_room_table1;
                $data['date_room_next_reservation1'] = "";
            }
        }

        $room2 = $this->room_m->get_event($date, $hour, $roomid2);
        $next_room2 = $this->room_m->get_next_event($date, $hour, $roomid2);
        $next_room_table2 = $this->room_m->get_next_event_table($date, $hour, $roomid2);
        

        if ($room2 != 0) {
            $data['data_room_desc2'] = $room2['CHR_MEETING_DESC'];
            $data['data_room_date2'] = date("jS F, Y", strtotime($room2['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($room2['CHR_TIME_FROM'])) . ' - ' . date("H:i", strtotime($room2['CHR_TIME_TO']));
            if ($next_room2 != 0) {
                $data['data_room_next_reservation2'] = $next_room2['CHR_MEETING_DESC'];
                $data['date_room_next_reservation2'] = date("jS F, Y", strtotime($next_room2['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room2['CHR_TIME_FROM']));
                $data['data_room_next_reservation_table2'] = $next_room_table2;
            } else {
                $data['data_room_next_reservation2'] = 'No Reservation';
                $data['data_room_next_reservation_table2'] = $next_room_table2;
                $data['date_room_next_reservation2'] = "";
            }
        } else {
            $data['data_room_desc2'] = 'Available';
            $data['data_room_date2'] = "";
            if ($next_room2 != 0) {
                $data['data_room_next_reservation2'] = $next_room2['CHR_MEETING_DESC'];
                $data['date_room_next_reservation2'] = date("jS F, Y", strtotime($next_room2['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room2['CHR_TIME_FROM']));
                $data['data_room_next_reservation_table2'] = $next_room_table2;
            } else {
                $data['data_room_next_reservation2'] = 'No Reservation';
                $data['data_room_next_reservation_table2'] = $next_room_table2;
                $data['date_room_next_reservation2'] = "";
            }
        }

        $this->load->view($content, $data);
    }

    public function updateAjax() {
        $date = date('Ymd');
        $hour = date('His');

        $roomid = $this->input->post('idroom');

        $room = $this->room_m->get_event($date, $hour, $roomid);
        $next_room = $this->room_m->get_next_event($date, $hour, $roomid);
        $next_room_table = $this->room_m->get_next_event_table($date, $hour, $roomid);


        if ($room != 0) {
            $data_room_desc = $room['CHR_MEETING_DESC'];
            $data_room_date = date("jS F, Y", strtotime($room['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($room['CHR_TIME_FROM'])) . ' - ' . date("H:i", strtotime($room['CHR_TIME_TO']));
            if ($next_room != 0) {
                $data_room_next_reservation = $next_room['CHR_MEETING_DESC'];
                $date_room_next_reservation = date("jS F, Y", strtotime($next_room['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room['CHR_TIME_FROM']));
                $data_room_next_reservation_table = $next_room_table;
            } else {
                $data_room_next_reservation = 'No Reservation';
                $data_room_next_reservation_table = $next_room_table;
                $date_room_next_reservation = '';
            }
        } else {
            $data_room_desc = 'Available';
            $data_room_date = "";
            if ($next_room != 0) {
                $data_room_next_reservation = $next_room['CHR_MEETING_DESC'];
                $date_room_next_reservation = date("jS F, Y", strtotime($next_room['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room['CHR_TIME_FROM']));
                $data_room_next_reservation_table = $next_room_table;
            } else {
                $data_room_next_reservation = 'No Reservation';
                $data_room_next_reservation_table = $next_room_table;
                $date_room_next_reservation = '';
            }
        }

        $data_table = "";

        if (count($data_room_next_reservation_table) > 0) {
            $data_table .= "<div class='col-md-6' style='margin-left:340px;margin-right: auto;color: white;' id='nextRoomTable'>
                            <div class='grid no-border'>
                            <div class='grid-header'>
                            <i class='fa fa-bookmark'></i>
                            <span class='grid-title'>Next Reservation</span>
                            </div>
                            <div class='grid-body'>
                            <table class='table table-bordered'>
                            <thead>
                            <tr>
                            <th style='text-align: center;'>No</th>
                            <th style='text-align: center;'>Date</th>
                            <th style='text-align: center;'>Time</th>
                            <th style='text-align: center;'>Activity</th>
                            <th style='text-align: center;'>PIC</th>
                            </tr>
                            </thead>
                            <tbody >";
            $i = 1;
            foreach ($data_room_next_reservation_table as $value_room) {
                $data_table .= "
                            <tr>
                            <td>$i
                            </td>
                            <td>" . date("jS F, Y", strtotime($value_room->CHR_DATE_FROM)) . "
                            </td>
                            <td>" . date("H:i", strtotime($value_room->CHR_TIME_FROM)) . " - " . date("H:i", strtotime($value_room->CHR_TIME_TO)) . "
                            </td>
                            <td>" . $value_room->CHR_MEETING_DESC . "
                            </td>
                            <td>" . $value_room->CHR_MEETING_PIC . "
                            </td>
                            </tr>";
                $i++;
            }

            $data_table .= "</tbody> 
                            </table>
                            </div>
                            </div>
                            </div>";
        }
        echo json_encode(array("data_table" => "$data_table", "data_room_desc" => "$data_room_desc", "data_room_date" => "$data_room_date", "data_room_next_reservation" => "$data_room_next_reservation", "date_room_next_reservation" => "$date_room_next_reservation"));
    }

    public function updateAjax_guestroom() {
        $date = date('Ymd');
        $hour = date('His');

        $roomid1 = $this->input->post('idroom1');
        $roomid2 = $this->input->post('idroom2');

        $room1 = $this->room_m->get_event($date, $hour, $roomid1);
        $next_room1 = $this->room_m->get_next_event($date, $hour, $roomid1);
        $next_room_table1 = $this->room_m->get_next_event_table($date, $hour, $roomid1);

        if ($room1 != 0) {
            $data_room_desc1 = $room1['CHR_MEETING_DESC'];
            $data_room_date1 = date("jS F, Y", strtotime($room1['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($room1['CHR_TIME_FROM'])) . ' - ' . date("H:i", strtotime($room1['CHR_TIME_TO']));
            if ($next_room1 != 0) {
                $data_room_next_reservation1 = $next_room1['CHR_MEETING_DESC'];
                $date_room_next_reservation1 = date("jS F, Y", strtotime($next_room1['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room1['CHR_TIME_FROM']));
                $data_room_next_reservation_table1 = $next_room_table1;
            } else {
                $data_room_next_reservation1 = 'No Reservation';
                $data_room_next_reservation_table1 = $next_room_table1;
                $date_room_next_reservation1 = '';
            }
        } else {
            $data_room_desc1 = 'Available';
            $data_room_date1 = "";
            if ($next_room1 != 0) {
                $data_room_next_reservation1 = $next_room1['CHR_MEETING_DESC'];
                $date_room_next_reservation1 = date("jS F, Y", strtotime($next_room1['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room1['CHR_TIME_FROM']));
                $data_room_next_reservation_table1 = $next_room_table1;
            } else {
                $data_room_next_reservation1 = 'No Reservation';
                $data_room_next_reservation_table1 = $next_room_table1;
                $date_room_next_reservation1 = '';
            }
        }

        $data_table1 = "";

        if (count($data_room_next_reservation_table1) > 0) {
            $data_table1 .= "<div class='col-md-6' style='margin-left:340px;margin-right: auto;color: white;' id='nextRoomTable'>
                            <div class='grid no-border'>
                            <div class='grid-header'>
                            <i class='fa fa-bookmark'></i>
                            <span class='grid-title'>Next Reservation</span>
                            </div>
                            <div class='grid-body'>
                            <table class='table table-bordered'>
                            <thead>
                            <tr>
                            <th style='text-align: center;'>No</th>
                            <th style='text-align: center;'>Date</th>
                            <th style='text-align: center;'>Time</th>
                            <th style='text-align: center;'>Activity</th>
                            <th style='text-align: center;'>PIC</th>
                            </tr>
                            </thead>
                            <tbody >";
            $i = 1;
            foreach ($data_room_next_reservation_table1 as $value_room1) {
                $data_table1 .= "
                            <tr>
                            <td>$i
                            </td>
                            <td>" . date("jS F, Y", strtotime($value_room1->CHR_DATE_FROM)) . "
                            </td>
                            <td>" . date("H:i", strtotime($value_room1->CHR_TIME_FROM)) . " - " . date("H:i", strtotime($value_room1->CHR_TIME_TO)) . "
                            </td>
                            <td>" . $value_room1->CHR_MEETING_DESC . "
                            </td>
                            <td>" . $value_room1->CHR_MEETING_PIC . "
                            </td>
                            </tr>";
                $i++;
            }

            $data_table1 .= "</tbody> 
                            </table>
                            </div>
                            </div>
                            </div>";
        }

        $room2 = $this->room_m->get_event($date, $hour, $roomid2);
        $next_room2 = $this->room_m->get_next_event($date, $hour, $roomid2);
        $next_room_table2 = $this->room_m->get_next_event_table($date, $hour, $roomid2);

        if ($room2 != 0) {
            $data_room_desc2 = $room2['CHR_MEETING_DESC'];
            $data_room_date2 = date("jS F, Y", strtotime($room2['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($room2['CHR_TIME_FROM'])) . ' - ' . date("H:i", strtotime($room2['CHR_TIME_TO']));
            if ($next_room2 != 0) {
                $data_room_next_reservation2 = $next_room2['CHR_MEETING_DESC'];
                $date_room_next_reservation2 = date("jS F, Y", strtotime($next_room2['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room2['CHR_TIME_FROM']));
                $data_room_next_reservation_table2 = $next_room_table2;
            } else {
                $data_room_next_reservation2 = 'No Reservation';
                $data_room_next_reservation_table2 = $next_room_table2;
                $date_room_next_reservation2 = '';
            }
        } else {
            $data_room_desc2 = 'Available';
            $data_room_date2 = "";
            if ($next_room2 != 0) {
                $data_room_next_reservation2 = $next_room2['CHR_MEETING_DESC'];
                $date_room_next_reservation2 = date("jS F, Y", strtotime($next_room2['CHR_DATE_FROM'])) . ' ' . date("H:i", strtotime($next_room2['CHR_TIME_FROM']));
                $data_room_next_reservation_table2 = $next_room_table2;
            } else {
                $data_room_next_reservation2 = 'No Reservation';
                $data_room_next_reservation_table2 = $next_room_table2;
                $date_room_next_reservation2 = '';
            }
        }

        $data_table2 = "";

        if (count($data_room_next_reservation_table2) > 0) {
            $data_table2 .= "<div class='col-md-6' style='margin-left:340px;margin-right: auto;color: white;' id='nextRoomTable'>
                            <div class='grid no-border'>
                            <div class='grid-header'>
                            <i class='fa fa-bookmark'></i>
                            <span class='grid-title'>Next Reservation</span>
                            </div>
                            <div class='grid-body'>
                            <table class='table table-bordered'>
                            <thead>
                            <tr>
                            <th style='text-align: center;'>No</th>
                            <th style='text-align: center;'>Date</th>
                            <th style='text-align: center;'>Time</th>
                            <th style='text-align: center;'>Activity</th>
                            <th style='text-align: center;'>PIC</th>
                            </tr>
                            </thead>
                            <tbody >";
            $i = 1;
            foreach ($data_room_next_reservation_table2 as $value_room2) {
                $data_table2 .= "
                            <tr>
                            <td>$i
                            </td>
                            <td>" . date("jS F, Y", strtotime($value_room2->CHR_DATE_FROM)) . "
                            </td>
                            <td>" . date("H:i", strtotime($value_room2->CHR_TIME_FROM)) . " - " . date("H:i", strtotime($value_room2->CHR_TIME_TO)) . "
                            </td>
                            <td>" . $value_room2->CHR_MEETING_DESC . "
                            </td>
                            <td>" . $value_room2->CHR_MEETING_PIC . "
                            </td>
                            </tr>";
                $i++;
            }

            $data_table2 .= "</tbody> 
                            </table>
                            </div>
                            </div>
                            </div>";
        }

        echo json_encode(array("data_table1" => "$data_table1", "data_room_desc1" => "$data_room_desc1", "data_room_date1" => "$data_room_date1", "data_room_next_reservation1" => "$data_room_next_reservation1", "date_room_next_reservation1" => "$date_room_next_reservation1",
            "data_table2" => "$data_table2", "data_room_desc2" => "$data_room_desc2", "data_room_date2" => "$data_room_date2", "data_room_next_reservation2" => "$data_room_next_reservation2", "date_room_next_reservation2" => "$date_room_next_reservation2"));
    }

}
?>
