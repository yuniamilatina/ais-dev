<?php

class Report_eff_prod_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes_new/production_result_m');
    }

    public function index() {
        $this->role_module_m->authorization('39');

        $data['title'] = 'Report Efficiency';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(117);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_eff_prod_v';

        $date= date('Ym');

        $data['data_effiency'] = $this->production_result_m->select_data_efficiency_per_week();
        $data['data_weekly'] = $this->production_result_m->get_weekly_report_efficiency_per_week();
        $data['data_monthly'] = $this->production_result_m->select_data_efficiency_per_date($date);

        // print_r($data['data_weekly']);
        // exit();
        
        $this->load->view($this->layout, $data);
    }

}
