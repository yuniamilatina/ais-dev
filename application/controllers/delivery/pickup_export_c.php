<?php

class pickup_export_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('delivery/picking_list_m');
    }

    public function index($start_date = null, $finish_date = null, $start_time = null, $finish_time = null) {
        if ($this->input->post('btn_submit')) {
            $start_date = date("Ymd", strtotime($this->input->post('start_date')));
            $finish_date = date("Ymd", strtotime($this->input->post('finish_date')));
            $start_time = date("His", strtotime($this->input->post('start_time')));
            $finish_time = date("His", strtotime($this->input->post('finish_time')));

            $data['start_date'] = date("d-m-Y", strtotime($this->input->post('start_date')));
            $data['finish_date'] = date("d-m-Y", strtotime($this->input->post('finish_date')));
            $data['start_time'] = date("H:i", strtotime($start_time));
            $data['finish_time'] = date("H:i", strtotime($finish_time));
        }
        if ($start_date == null and $finish_date == null) {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
            $start_time = date("His");
            $finish_time = date("His");

            $data['start_date'] = date("d-m-Y");
            $data['finish_date'] = date("d-m-Y");
            $data['start_time'] = date("H:i");
            $data['finish_time'] = date("H:i");
        } elseif ($start_date == null) {
            $start_date = date("Ymd");
            $start_time = date("His");

            $data['start_date'] = date("d-m-Y");
            $data['start_time'] = date("H:i");
        } elseif ($finish_date == null) {
            $finish_date = date("Ymd");
            $finish_time = date("His");
            
            $data['finish_date'] = date("d-m-Y");
            $data['finish_time'] = date("H:i");
        }

        $data['content'] = 'delivery/report_pickup_export_v';
        $data['title'] = 'Pick Up Export';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(138);
        $data['news'] = $this->news_m->get_news();

        $data['data_pickup_export'] = $this->picking_list_m->select_pickup_export($start_date, $finish_date, $start_time, $finish_time);
        $this->load->view($this->layout, $data);
    }
}
