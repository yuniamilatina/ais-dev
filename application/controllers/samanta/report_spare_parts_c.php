<?php

class report_spare_parts_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('samanta/spare_parts_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('samanta/report_spare_parts_m');
    }

    public function report_spare_parts($date = '', $group_line = '') {
        $this->role_module_m->authorization('16');
        // $this->log_m->add_log(10, NULL);

        $data['title'] = 'Report In Out Tools';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(310);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'samanta/report_spare_parts_v';

        if($date == '' || $date == NULL){
            $date = date('Y') . date('m');
        }
        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }
        
        $data['all_group_line'] = $this->report_spare_parts_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['selected_date'] = $date;

        $data['data_transaction_in'] = $this->report_spare_parts_m->get_data_pivot_transaction_in_per_periode($date, $group_line);
        $data['data_transaction_out'] = $this->report_spare_parts_m->get_data_pivot_transaction_out_per_periode($date, $group_line);
        
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
