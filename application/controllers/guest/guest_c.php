<?php

class guest_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'guest/guest_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('guest/guest_m');
        $this->load->model('basis/user_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->guest_m->get_all_guest();
        $data['content'] = 'guest/manage_guest_v';
        $data['title'] = 'Manage Guest';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(180);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_guest() {
        $this->role_module_m->authorization('3');
        $data['content'] = 'guest/create_guest_v';
        $data['title'] = 'Create Guest';

        $data['user'] = $this->user_m->get_user();

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(180);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_guest() {
        $this->form_validation->set_rules('CHR_FIRST_NAME', 'First Name', 'required');
        // $this->form_validation->set_rules('CHR_LAST_NAME', 'Last Name', 'required');
        $date = date("Ymd", strtotime($this->input->post('CHR_SCHEDULE_DATE')));
        $time = date("His", strtotime($this->input->post('CHR_SCHEDULE_TIME')));

        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_guest();
        } else {
            $data = array(
                'CHR_FIRST_NAME' => $this->input->post('CHR_FIRST_NAME'),
                // 'CHR_LAST_NAME' => $this->input->post('CHR_LAST_NAME'),
                'CHR_SCHEDULE_DATE' => $date,
                'CHR_SCHEDULE_TIME' => $time,
                // 'CHR_COMPANY' => $this->input->post('CHR_COMPANY'),
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->guest_m->save_guest($data);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function select_by_id($id, $msg = NULL) {
        $this->role_module_m->authorization('3');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->guest_m->get_data_inlguestcan($id)->row();
        $data['data_guest'] = $this->guest_m->get_inlguestcan();
        $data['content'] = 'guest/view_guest_v';
        $data['title'] = 'View In Line Scan';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(180);

        $this->load->view($this->layout, $data);
    }

    //prepare to editing
    function edit_guest($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->guest_m->get_data_guest($id);
        $data['content'] = 'guest/edit_guest_v';
        $data['title'] = 'Edit Guest';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(180);

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_guest() {
        $id = $this->input->post('INT_ID');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_FIRST_NAME', 'First Name', 'required');
        // $this->form_validation->set_rules('CHR_LAST_NAME', 'Last Name', 'required');
        $date = date("Ymd", strtotime($this->input->post('CHR_SCHEDULE_DATE')));
        $time = date("His", strtotime($this->input->post('CHR_SCHEDULE_TIME')));

        if ($this->form_validation->run() == FALSE) {
            $this->edit_guest($id);
        } else {
            $data = array(
                'CHR_FIRST_NAME' => $this->input->post('CHR_FIRST_NAME'),
                // 'CHR_LAST_NAME' => $this->input->post('CHR_LAST_NAME'),
                'CHR_SCHEDULE_DATE' => $date,
                'CHR_SCHEDULE_TIME' => $time,
                // 'CHR_COMPANY' => $this->input->post('CHR_COMPANY'),
                'CHR_CREATED_BY' => $session['USERNAME']
            );

            $this->guest_m->update($data, $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_guest($id) {
        $this->role_module_m->authorization('3');
        $this->guest_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function get_guest_today() {
        $data = $this->guest_m->get_top5_guest();

        $result = '';
        foreach ($data as $isi) {
            $result .= "<h3 style='font-size: 40px;' class='animated fadeInDown'>";
            $result .= $isi->CHR_FIRSTNAME . ' ' . $isi->CHR_LASTNAME. ' - ' .$isi->CHR_COMPANY;
            $result .= "</h3>";
        }

        echo $result;
    }

    function get_guest_today1() {
        $data = $this->guest_m->get_top_guest_1();

        $result = '';
        foreach ($data as $isi) {
            $result .= "<h3 style='font-size: 40px;' class='animated fadeInDown'>";
            $result .= $isi->CHR_FIRSTNAME;
            $result .= "</h3>";
        }

        echo $result;
    }

    function get_guest_today2() {
        $data = $this->guest_m->get_top_guest_2();

        $result = '';
        foreach ($data as $isi) {
            $result .= "<h3 style='font-size: 40px;' class='animated fadeInDown'>";
            $result .= $isi->CHR_FIRSTNAME;
            $result .= "</h3>";
        }

        echo $result;
    }

    function get_guest_today3() {
        $data = $this->guest_m->get_top_guest_3();

        $result = '';
        foreach ($data as $isi) {
            $result .= "<h3 style='font-size: 40px;' class='animated fadeInDown'>";
            $result .= $isi->CHR_FIRSTNAME;
            $result .= "</h3>";
        }

        echo $result;
    }

}
