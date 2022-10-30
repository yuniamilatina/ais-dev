<?php

class Report_preventive_planning_injection_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('mte/mold_m');
        $this->load->model('pes_new/production_result_m');
    }

    public function index() {
        $data['title'] = 'Report Preventive Planning Injection';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(256);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_preventive_planning_injection_v';

        $data['data'] = $this->production_result_m->get_data_accumulative_production_using_mold();

        $this->load->view($this->layout, $data);
    }

}
