<?php

class report_mrp_c extends CI_Controller
{

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_index = '/mrp/report_mrp_c/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('prd/group_line_m');
        $this->load->model('mrp/manage_mrp_m');
        $this->load->model('mrp/report_mrp_m');
        $this->load->model('part/part_m');
    }

    function index($group_prd = NULL, $work_center = NULL, $period = NULL, $cust = NULL) {
        $session = $this->session->all_userdata();
        
        if ($group_prd == NULL || $group_prd == '') {
            $group_prd = $this->manage_mrp_m->get_top_group_prd()->row()->CHR_GROUP_PRODUCT_CODE;
        }

        if ($work_center == NULL) {
            $work_center = "";// $this->manage_mrp_m->get_top_work_center_by_group_prd($group_prd);
        }

        if ($period == NULL || $period == '') {
            $period = date('Ym');
        }

        if ($cust == NULL || $cust == '') {
            $cust = '';
        }

        $all_group_prd = $this->manage_mrp_m->get_all_group_prd();
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd($group_prd);
        
        $data['all_group_prd'] = $all_group_prd->result();        
        $data['group_prd'] = $group_prd;
        $data['all_work_centers'] = $all_work_centers->result();
        $data['work_center'] = $work_center;

        $data['period'] = $period; 
        
        $get_cust = $this->report_mrp_m->get_list_cust();
        $get_data = $this->report_mrp_m->get_actual_order_vs_delivey_by_group_and_date($group_prd, $work_center, $period, $cust);
        
        $data['title'] = 'Report Actual Order vs Delivery';
        $data['content'] = 'mrp/report_mrp/report_actual_order_vs_delivery_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(354);
        $data['news'] = $this->news_m->get_news();
        $data['list_cust'] = $get_cust;  
        $data['cust'] = "";   
        $data['data'] = $get_data;        
        
        $this->load->view($this->layout, $data);
    }

    function search_report_actual_order_vs_delivery() {
        $session = $this->session->all_userdata();

        $group_prd = $this->input->post("group_prd");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $period = $this->input->post("period");
        $cust = $this->input->post("cust");

        $all_group_prd = $this->manage_mrp_m->get_all_group_prd();
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd($group_prd);
        
        $data['all_group_prd'] = $all_group_prd->result();        
        $data['group_prd'] = $group_prd;
        $data['all_work_centers'] = $all_work_centers->result();
        $data['work_center'] = $work_center;

        $data['period'] = $period; 
        $get_cust = $this->report_mrp_m->get_list_cust();
        $get_data = $this->report_mrp_m->get_actual_order_vs_delivey_by_group_and_date($group_prd, $work_center, $period, $cust);
        
        $data['title'] = 'Report Actual Order vs Delivery';
        $data['content'] = 'mrp/report_mrp/report_actual_order_vs_delivery_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(354);
        $data['news'] = $this->news_m->get_news();
        $data['list_cust'] = $get_cust; 
        $data['cust'] = $cust;   
        $data['data'] = $get_data;      
        
        $this->load->view($this->layout, $data);
    }

}
