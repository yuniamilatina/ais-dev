<?php

class scan_out_plastic_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('raw_material/raw_material_m');
        $this->load->model('raw_material/good_movement_m');
    }
    
    public function index($start_date = null, $finish_date = null) {
        if ($this->input->post('btn_submit')) {
            $start_date = $this->input->post('start_date');
            $finish_date = $this->input->post('finish_date');
            $start_date = date("Ymd", strtotime($start_date));
            $finish_date = date("Ymd", strtotime($finish_date));
        }
        if ($start_date == null and $finish_date == null) {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
        } elseif ($start_date == null) {
            $start_date = date("Ymd");
        } elseif ($finish_date == null) {
            $finish_date = date("Ymd");
        }

        $data['start_date'] = date("d-m-Y", strtotime($start_date));
        $data['finish_date'] = date("d-m-Y", strtotime($finish_date));
        $data['content'] = 'raw_material/report_scan_out_plastic_raw_material_v';
        $data['title'] = 'Scan Out';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(127);
        $data['news'] = $this->news_m->get_news();
        $data['data_scan_out'] = $this->good_movement_m->get_data_scan_out_plastic($start_date, $finish_date);

        $this->load->view($this->layout, $data);
    }

    public function summary($start_date = null, $finish_date = null) {
        if ($this->input->post('btn_submit')) {
            $start_date = $this->input->post('start_date');
            $finish_date = $this->input->post('finish_date');
            $start_date = date("Ymd", strtotime($start_date));
            $finish_date = date("Ymd", strtotime($finish_date));
        }
        if ($start_date == null and $finish_date == null) {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
        } elseif ($start_date == null) {
            $start_date = date("Ymd");
        } elseif ($finish_date == null) {
            $finish_date = date("Ymd");
        }

        $data['start_date'] = date("d-m-Y", strtotime($start_date));
        $data['finish_date'] = date("d-m-Y", strtotime($finish_date));
        $data['content'] = 'raw_material/report_scan_out_plastic_summary_raw_material_v';
        $data['title'] = 'Scan Out Summary';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(129);
        $data['news'] = $this->news_m->get_news();
        $data['data_scan_out'] = $this->good_movement_m->get_data_summary_scan_out_plastic($start_date, $finish_date);

        $this->load->view($this->layout, $data);
    }

}
