<?php

class Report_efficiency_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('prd/group_line_m');
    }

    public function index($date = null , $id_product_group = null) {
        $data['title'] = 'Report Efficiency';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(134);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_efficiency_v';

        if($id_product_group == null || $id_product_group == ''){
            $id_product_group = 0;
        }

        if($date == null || $date == ''){
            $date = date('Ym');
        }

        $data['data_effiency'] = $this->production_result_m->select_data_efficiency_by_period($date, $id_product_group);
        $data['data_downtime'] = $this->production_result_m->select_data_downtime_by_period($date, $id_product_group);

        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['id_product_group'] = $id_product_group;

        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $this->load->view($this->layout, $data);
    }

    function firstSunday($date)
    {
        for($day = 1; $day <= 7; $day++){
            $dd = strftime("%A",strtotime($date.'-'.$day));
            if($dd == 'Sunday'){
                return strftime("%Y-%m-%d",strtotime($date.'-'.$day));
            }
        }
    }
    
    function firstSaturday($date)
    {
        for($day = 1; $day <= 7; $day++){
            $dd = strftime("%A",strtotime($date.'-'.$day));
            if($dd == 'Saturday'){
                return strftime("%Y-%m-%d",strtotime($date.'-'.$day));
            }
        }
    }
}
