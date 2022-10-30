<?php

class room_reservation_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'room/room_reservation_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('room/room_m');
        $this->load->model('room/room_reservation_m');
        $this->load->model('room/attendance_m');

    }

    public function index($msg = null) {
        $this->role_module_m->authorization('72');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Reservation Failed !</strong> That room is not available</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['content'] = 'room/room_reservation/manage_reservation_v';
        $data['title'] = "Maintain Reservation";

        //$date = date('Ymd');

        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(131);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->room_reservation_m->get_all_reservation_by_date();

        $this->load->view($this->layout, $data);
    }

    public function create_reservation() {
        $this->role_module_m->authorization('131');

        $data['content'] = 'room/room_reservation/create_reservation_v';
        $data['title'] = "Create Reservation";

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(131);
        $data['news'] = $this->news_m->get_news();
//        $data['new_year'] = date('Y');
//        $data['new_month'] = date('m');

        $data['room'] = $this->room_m->get_all_room();
        $data['dept'] = $this->dept_m->get_dept();

        $this->load->view($this->layout, $data);
    }

    //Checking dept id
    function check_available($room_id, $start_date, $start_time, $finish_date, $finish_time) {
        $available = $this->room_reservation_m->cek_available_room($room_id, $start_date, $start_time, $finish_date, $finish_time);

        return $available;
    }

    function save_reservation() {

        $flg_genba = 0;
        $flg_meeting = 0;
        $flg_conference = 0;

        if ($this->input->post('INT_FLG_GENBA') == 1) {
            $flg_genba = 1;
        }
        if ($this->input->post('INT_FLG_MEETING') == 1) {
            $flg_meeting = 1;
        }
        if ($this->input->post('INT_FLG_CONFERENCE') == 1) {
            $flg_conference = 1;
        }

        //ini cek kosong apa kagak doang cuy
        $this->form_validation->set_rules('meeting_desc', 'Meeting Desc', 'required');
        $this->form_validation->set_rules('meeting_pic', 'PIC', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('finish_date', 'Finish Date', 'required');

        //sengaja dibikin panjang biar jeli
        if ($this->check_available($this->input->post("room"), date("Ymd", strtotime($this->input->post("start_date"))), date("His", strtotime($this->input->post("start_date"))), date("Ymd", strtotime($this->input->post("finish_date"))), date("His", strtotime($this->input->post("finish_date")))) == true) {

            //generated id nya kocak, kepanjangan pake room id  tanggal jam menit detik ama id department
            $id = $this->generate_id_reservation(trim($this->input->post('room')), trim($this->input->post('dept')));

            if ($this->form_validation->run() == FALSE) {
                $this->create_reservation();
            } else {
                $data = array(
                    'CHR_ID_RESERV' => $id,
                    'CHR_MEETING_DESC' => $this->input->post('meeting_desc'),
                    'CHR_MEETING_PIC' => $this->input->post('meeting_pic'),
                    'CHR_KODE_ROOM' => $this->input->post("room"),
                    'CHR_DATE_FROM' => date("Ymd", strtotime($this->input->post("start_date"))),
                    'CHR_DATE_TO' => date("Ymd", strtotime($this->input->post("finish_date"))),
                    'CHR_TIME_FROM' => date("His", strtotime($this->input->post("start_date"))),
                    'CHR_TIME_TO' => date("His", strtotime($this->input->post("finish_date"))),
                    'CHR_MEETING_DEPT' => $this->input->post('dept'),
                    'INT_FLG_GENBA' => $flg_genba,
                    'INT_FLG_MEETING' => $flg_meeting,
                    'INT_FLG_CONFERENCE' => $flg_conference,
                    'CHR_AGENDA' => trim($this->input->post('CHR_AGENDA')),
                    'BIT_FLG_DEL' => 1
                );
                $this->room_reservation_m->save_reservation($data);
//                $this->log_m->add_log('39', $id);
                redirect($this->back_to_manage . $msg = 1);
            }
        } else {
            redirect($this->back_to_manage . $msg = 4);
        }
    }

    function generate_id_reservation($room, $dept) {
        return $room . '-' . date('YmdHis') . '-' . $dept;
    }

    //View to editing
    function view_reservation($id) {
        $this->role_module_m->authorization('131');
        $data['data'] = $this->room_reservation_m->get_data_reservation($id)->row();
        $data['data_attendance'] = $this->attendance_m->get_data_attendance_by_id_reserv($id);

        $data['content'] = 'room/room_reservation/view_reservation_v';
        $data['title'] = 'View Room Reservation';

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(131);

        $this->load->view($this->layout, $data);
    }
    
    //prepare to editing
    function edit_reservation($id) {
        $this->role_module_m->authorization('131');
        $data['data'] = $this->room_reservation_m->get_data_reservation($id)->row();

        $data['content'] = 'room/room_reservation/edit_reservation_v';
        $data['title'] = 'Edit Room Reservation';

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(131);

        $data['room'] = $this->room_m->get_all_room();
        $data['dept'] = $this->dept_m->get_dept();

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_reservation() {
        $id = $this->input->post('CHR_ID_RESERV');
        $msg = 2;

        $flg_genba = 0;
        $flg_meeting = 0;
        $flg_conference = 0;

        if ($this->input->post('INT_FLG_GENBA') == 1) {
            $flg_genba = 1;
        }
        if ($this->input->post('INT_FLG_MEETING') == 1) {
            $flg_meeting = 1;
        }
        if ($this->input->post('INT_FLG_CONFERENCE') == 1) {
            $flg_conference = 1;
        }

        $this->form_validation->set_rules('meeting_desc', 'Meeting Desc', 'required');
        $this->form_validation->set_rules('meeting_pic', 'PIC', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('finish_date', 'Finish Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_reservation($id);
        } else {
            $data = array(
                'CHR_MEETING_DESC' => $this->input->post('meeting_desc'),
                'CHR_MEETING_PIC' => $this->input->post('meeting_pic'),
                'CHR_KODE_ROOM' => $this->input->post("room"),
                'CHR_DATE_FROM' => date("Ymd", strtotime($this->input->post("start_date"))),
                'CHR_DATE_TO' => date("Ymd", strtotime($this->input->post("finish_date"))),
                'CHR_TIME_FROM' => date("His", strtotime($this->input->post("start_date"))),
                'CHR_TIME_TO' => date("His", strtotime($this->input->post("finish_date"))),
                'CHR_MEETING_DEPT' => $this->input->post('dept'),
                'INT_FLG_GENBA' => $flg_genba,
                'INT_FLG_MEETING' => $flg_meeting,
                'INT_FLG_CONFERENCE' => $flg_conference,
                'CHR_AGENDA' => trim($this->input->post('CHR_AGENDA'))
            );
            $this->room_reservation_m->update($data, $id);
//            $this->log_m->add_log('40', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_reservation($id) {
        $this->role_module_m->authorization('3');
        $this->room_reservation_m->delete($id);
//        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}

?>
