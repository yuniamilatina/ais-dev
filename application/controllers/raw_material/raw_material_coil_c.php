<?php

class Raw_material_coil_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('raw_material/raw_material_m');
        $this->load->model('raw_material/report_movement_m');
    }

    public function index($month = null, $year = null) {
        redirect("fail_c");
        if ($this->input->post('btn_submit')) {
            $month = $this->input->post('INT_ID_MONTH');
            $year = $this->input->post('INT_ID_YEAR');
            if (strlen($month) == 1) {
                $period = $year . '0' . $month;
            } else {
                $period = $year . $month;
            }
            $selected_month = date("F", mktime(0, 0, 0, $month, 1, 0));
        }
        if ($month == null || $year == null) {
            $month = date('m');
            $year = date('Y');
            if (strlen($month) == 1) {
                $period = $year . '0' . $month;
            } else {
                $period = $year . $month;
            }
            $selected_month = date('F');
        }

        $month_desc = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December');

        $data['selected_month'] = $selected_month;
        $data['month_desc'] = $month_desc;

        $data['content'] = 'raw_material/report_wh00_v';
        $data['title'] = 'WH00 Report';

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(119);
        $data['news'] = $this->news_m->get_news();
        $data['data_report_wh00'] = $this->raw_material_m->select_data_report_wh00_part_by_period($period);

        $this->load->view($this->layout, $data);
    }

    public function search_report_movement_by_periode() {

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'report/report_wh00_v';
        $data['title'] = 'WH00 Report';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(119);
        $data['news'] = $this->news_m->get_news();

        $month = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December');

        $data['month'] = $month;

        $Month = $this->input->post('INT_ID_MONTH');
        $Year = $this->input->post('INT_ID_YEAR');

        $data['new_year'] = $Year;
        $data['new_month'] = $Month;

        $data['pure'] = false;

        if (strlen($Month) == 1) {
            $period = $Year . '0' . $Month;
        } else {
            $period = $Year . $Month;
        }

        $data['data_movement_part'] = $this->report_movement_m->select_data_movement_part_by_period($period);
        $data['data_sum_movement_part'] = $this->report_movement_m->select_data_sum_movement_part_by_period($period);

        $this->load->view($this->layout, $data);
    }

    public function bod($month = null, $year = null) {
        redirect("fail_c");
        if ($this->input->post('btn_submit')) {
            $month = $this->input->post('INT_ID_MONTH');
            $year = $this->input->post('INT_ID_YEAR');
            if (strlen($month) == 1) {
                $period = $year . '0' . $month;
            } else {
                $period = $year . $month;
            }
            $selected_month = date("F", mktime(0, 0, 0, $month, 1, 0));
        }
        if ($month == null || $year == null) {
            $month = date('m');
            $year = date('Y');
            if (strlen($month) == 1) {
                $period = $year . '0' . $month;
            } else {
                $period = $year . $month;
            }
            $selected_month = date('F');
        }

        $month_desc = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December');

        $data['selected_month'] = $selected_month;
        $data['month_desc'] = $month_desc;

        $data['data_movement_part'] = $this->report_movement_m->select_data_movement_part_by_period($period);
        $data['data_sum_movement_part'] = $this->report_movement_m->select_data_sum_movement_part_by_period($period);

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $data['content'] = 'raw_material/report_rm_for_bod_v';
        $data['title'] = 'BOD Report';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(118);
        $data['news'] = $this->news_m->get_news();
        $this->load->view($this->layout, $data);
    }

}
