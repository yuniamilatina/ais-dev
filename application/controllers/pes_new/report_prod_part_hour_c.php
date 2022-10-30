<?php

class Report_prod_part_hour_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');

        $data['title'] = 'Report Productivity Hour';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(121);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_prod_part_hour_v';

        $date = date('d-m-Y');
        $work_center = $this->direct_backflush_general_m->get_top_work_center();

        $data['data_work_center'] = $this->direct_backflush_general_m->get_all_work_center();
        $data['work_center'] = trim($work_center);
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['date'] = $date;

        $data['data_hourly_production'] = $this->production_result_m->select_hourly_productivity_by_date_dept_and_work_center($date, $work_center);
        $data['data_hourly_line_stop_production'] = $this->production_result_m->select_hourly_line_stop_by_date_dept_and_work_center($date, $work_center);
        // $data['data_hourly_efficiency'] = $this->production_result_m->select_hourly_efficiency_date_and_work_center($date, $work_center);


        $this->load->view($this->layout, $data);
    }

    public function search_prod_part() {
        $date = $this->input->post('CHR_DATE');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(121);
        $data['news'] = $this->news_m->get_news();

        $data['data_work_center'] = $this->direct_backflush_general_m->get_all_work_center();
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['date'] = $date;
        $data['work_center'] = $work_center;
        $data['content'] = 'pes_new/report_prod_part_hour_v';
        $data['title'] = 'Report Productivity Hour';

        $data['data_hourly_production'] = $this->production_result_m->select_hourly_productivity_by_date_dept_and_work_center($date, $work_center);
        $data['data_hourly_line_stop_production'] = $this->production_result_m->select_hourly_line_stop_by_date_dept_and_work_center($date, $work_center);
        // $data['data_hourly_efficiency'] = $this->production_result_m->select_hourly_efficiency_date_and_work_center($date, $work_center);

        $this->load->view($this->layout, $data);
    }

}
