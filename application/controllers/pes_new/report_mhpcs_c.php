<?php

class Report_mhpcs_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->log_m->add_log(3, NULL);

        $data['title'] = 'Report Prod per Hour per MP';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(149);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_mhpcs_v';

        $date = date('Y') . date('m');

        if ($this->session->userdata('ROLE') == 16 || $this->session->userdata('ROLE') == 17 || $this->session->userdata('ROLE') == 6 || $this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 32) { //Root & Prod Leader & SPV & Manager
            $id_dept = $this->session->userdata('DEPT');
            $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
        }
        else  { 
            $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
            $dept = $this->dept_m->get_top_prod_dept()->row()->CHR_DEPT;
        }

        $data['data_prod_per_hour_per_mp'] = $this->production_result_m->select_data_prod_per_hour_per_mp_by_date_and_dept($date, $id_dept);
        //$data['data_mp_per_pcs'] = $this->production_result_m->select_data_mp_per_pcs_by_period($date, $id_dept);

        $data_work_center = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();

        $data['fiscal_year'] = $this->production_result_m->get_fiscal_year_by_period($date);
        $data['all_work_centers'] = $data_work_center;
        $data['all_dept_prod'] = $all_dept_prod;
        $data['work_center'] = $work_center;

        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        $data['id_prod'] = $id_dept;
        $data['dept_name'] = $dept;
        $data['role'] = $this->session->userdata('ROLE');
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $this->load->view($this->layout, $data);
    }

    public function search_prod_entry($date = '', $id_dept = '') {
        $this->role_module_m->authorization('16');

        $data['content'] = 'pes_new/report_mhpcs_v';
        $data['title'] = 'Report Prod per Hour per MP';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(149);
        $data['news'] = $this->news_m->get_news();

        $data_work_center = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;

        $data['fiscal_year'] = $this->production_result_m->get_fiscal_year_by_period($date);
        $data['all_work_centers'] = $data_work_center;
        $data['all_dept_prod'] = $all_dept_prod;
        $data['work_center'] = $work_center;

        $data['data_prod_per_hour_per_mp'] = $this->production_result_m->select_data_prod_per_hour_per_mp_by_date_and_dept($date, $id_dept);
        //$data['data_mp_per_pcs'] = $this->production_result_m->select_data_mp_per_pcs_by_period($date, $id_dept);

        $data['role'] = $this->session->userdata('ROLE');
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        $data['id_prod'] = $id_dept;
        $data['dept_name'] = $dept;
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
