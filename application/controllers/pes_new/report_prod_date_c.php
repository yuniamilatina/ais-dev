<?php

class Report_prod_date_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('pes/target_production_m');
        $this->load->model('pes/threshold_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->log_m->add_log(10, NULL);

        $data['title'] = 'Production Performance';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(126);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_prod_date_v';

        $date = date('Y') . date('m');
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $work_center = $this->direct_backflush_general_m->get_top_work_center();

        $data['target'] = $this->target_production_m->get_data_target_by_workcenter_and_period($work_center, $date);
        $data['threshold_performance'] = $this->threshold_m->get_data_threshold('performance');
        $data['fiscal_year'] = $this->production_result_m->get_fiscal_year_by_period($date);
        $data['all_work_centers'] = $data_work_center;
        $data['work_center'] = $work_center;
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        $data['role'] = $this->session->userdata('ROLE');
        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $data['data_prod_entry_qty'] = $this->production_result_m->select_data_prod_qty_by_date_and_dept_and_work_center($date, $work_center);
        $data['data_prod_ok_and_ng'] = $this->production_result_m->select_total_part_work_center_by_dept_and_date_and_work_center($date, $work_center);
        
        $data['status_detail_ng'] = $this->production_result_m->status_detail_ng_by_date_dept_and_workcenter($date, $work_center);
        $data['data_detail_ng'] = $this->production_result_m->select_detail_ng_by_date_dept_and_workcenter($date, $work_center);
        $data['detail_ng_per_part'] = $this->production_result_m->select_detail_ng_per_part_by_date_dept_and_workcenter($date, $work_center);
        
        $data['status_detail_line_stop'] = $this->production_result_m->status_detail_line_stop_by_date_and_dept_and_work_center($date, $work_center);
        $data['data_prod_entry_detail_line_stop'] = $this->production_result_m->select_data_detail_line_stop_by_date_and_dept_and_work_center($date, $work_center);
        
        $data['data_man_minutes_perpieces'] = $this->production_result_m->select_data_man_minutes_perpieces_by_date_dept_and_workcenter($date, $work_center);
        $data['data_ratio_ril'] = $this->production_result_m->select_data_ratio_ril_by_date_dept_and_workcenter($date, $work_center);
        $data['data_efficiency'] = $this->production_result_m->select_data_efficiency_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout, $data);
    }

    public function search_prod_entry($date = '', $work_center = '') {

        $data['content'] = 'pes_new/report_prod_date_v';
        $data['title'] = 'Production Performance';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(126);
        $data['news'] = $this->news_m->get_news();

        //Threshold
        $data['target'] = $this->target_production_m->get_data_target_by_workcenter_and_period($work_center, $date);
        $data['threshold_performance'] = $this->threshold_m->get_data_threshold('performance');
        $data['fiscal_year'] = $this->production_result_m->get_fiscal_year_by_period($date);
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center();
        $data['work_center'] = $work_center;
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        $data['role'] = $this->session->userdata('ROLE');
        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $data['data_prod_entry_qty'] = $this->production_result_m->select_data_prod_qty_by_date_and_dept_and_work_center($date, $work_center);
        $data['data_prod_ok_and_ng'] = $this->production_result_m->select_total_part_work_center_by_dept_and_date_and_work_center($date, $work_center);

        $data['status_detail_ng'] = $this->production_result_m->status_detail_ng_by_date_dept_and_workcenter($date, $work_center);
        $data['data_detail_ng'] = $this->production_result_m->select_detail_ng_by_date_dept_and_workcenter($date, $work_center);
        $data['detail_ng_per_part'] = $this->production_result_m->select_detail_ng_per_part_by_date_dept_and_workcenter($date, $work_center);

        $data['status_detail_line_stop'] = $this->production_result_m->status_detail_line_stop_by_date_and_dept_and_work_center($date, $work_center);
        $data['data_prod_entry_detail_line_stop'] = $this->production_result_m->select_data_detail_line_stop_by_date_and_dept_and_work_center($date, $work_center);

        //iframe
        $data['data_man_minutes_perpieces'] = $this->production_result_m->select_data_man_minutes_perpieces_by_date_dept_and_workcenter($date, $work_center);
        $data['data_ratio_ril'] = $this->production_result_m->select_data_ratio_ril_by_date_dept_and_workcenter($date, $work_center);
        $data['data_efficiency'] = $this->production_result_m->select_data_efficiency_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout, $data);
    }

    function get_activity_prod($date, $work_center){

        $data['content'] = 'pes_new/prod_activtity_chart_v';

        $data['data_summary_production_shift1'] = $this->production_result_m->get_data_summary_productivity_shift1($date, $work_center, 1);
        $data['data_summary_production_shift2'] = $this->production_result_m->get_data_summary_productivity_shift2($date, $work_center, 2);
        $data['data_summary_production_shift3'] = $this->production_result_m->get_data_summary_productivity_shift3($date, $work_center, 3);
        $data['data_summary_production_shift4'] = $this->production_result_m->get_data_summary_productivity_shift4($date, $work_center, 4);
        
        $this->load->view($this->layout_blank, $data);
    }

    function get_summary_efficiency($date, $work_center){
        $data['content'] = 'pes_new/prod_summary_eff_chart_v';

        $data['summary_efficiency'] = $this->production_result_m->select_summary_efficiency_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout_blank, $data);
    }

    function get_summary_manminpcs($date, $work_center){
        $data['content'] = 'pes_new/prod_summary_manminpcs_chart_v';

        $data['summary_man_minutes_perpieces'] = $this->production_result_m->select_summary_man_minutes_perpieces_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout_blank, $data);
    }

    function get_summary_ril($date, $work_center){
        $data['content'] = 'pes_new/prod_summary_ril_chart_v';

        $data['summary_ratio_ril'] = $this->production_result_m->select_summary_ratio_ril_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout_blank, $data);
    }

    function get_efficiency($date, $work_center){
        $data['content'] = 'pes_new/prod_efficiency_chart_v';

        $data['threshold_efficiency'] = $this->threshold_m->get_data_threshold('efficiency');
        $data['threshold_average_efficiency'] = $this->production_result_m->select_data_efficiency_by_date_dept_and_workcenter_average($date, $work_center);

        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $data['data_efficiency'] = $this->production_result_m->select_data_efficiency_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout_blank, $data);
    }

    function get_manminpcs($date, $work_center){
        $data['content'] = 'pes_new/prod_manminpcs_chart_v';

        $data['threshold_manminpcs'] = $this->threshold_m->get_data_threshold('manminpcs');
        $data['threshold_average_manminpcs'] = $this->production_result_m->select_data_man_minutes_perpieces_by_date_dept_and_workcenter_average($date, $work_center);

        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $data['data_man_minutes_perpieces'] = $this->production_result_m->select_data_man_minutes_perpieces_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout_blank, $data);
    }

    function get_ril($date, $work_center){
        $data['content'] = 'pes_new/prod_ril_chart_v';

        $data['threshold_ratioril'] = $this->threshold_m->get_data_threshold('ratioril');

        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $data['data_ratio_ril'] = $this->production_result_m->select_data_ratio_ril_by_date_dept_and_workcenter($date, $work_center);

        $this->load->view($this->layout_blank, $data);
    }

    function firstSunday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function get_data_perhour() {
        $work_center = trim($this->input->post('work_center'));
        $date = trim($this->input->post('date'));
        $period = trim($this->input->post('period'));

        if (strlen($date) == 1) {
            $tanggal = $period . '0' . $date;
            $day = '0' . $date . '-' . substr($period, -2) . '-' . substr($period, 0, -2);
        } else {
            $tanggal = $period . $date;
            $day = $date . '-' . substr($period, -2) . '-' . substr($period, 0, -2);
        }

        $dept = trim($this->input->post('dept'));

        $data_summary_inventory_by_date = $this->production_result_m->select_perhour_qty_by_work_center_and_date($work_center, $tanggal);
        if ($data_summary_inventory_by_date == 0) {
            $valuenull = 0;
            echo $valuenull;
        } else {
            $data = "";
            $data .= "<script type='text/javascript'>";
            $data .= "var chart1; ";
            $data .= "$(document).ready(function () {";
            $data .= "chart1 = new Highcharts.Chart({";
            $data .= "chart: {renderTo: 'container', type: 'area', plotBorderWidth: 1}, credits: {enabled: false},legend: {borderColor: '#cccccc',borderWidth: 1,borderRadius: 3},tooltip:{split: true,valueSuffix:''},";
            $data .= "title: {text: ''},xAxis: {categories: ['06:00-06:59', '07:00-07:59', '08:00-08:59', '09:00-09:59', '10:00-10:59', '11:00-11:59','12:00-12:59', '13:00-13:59', '14:00-14:59', '15:00-15:59', '16:00-16:59', '17:00-17:59','18:00-18:59', '19:00-19:59', '20:00-20:59', '21:00-21:59', '22:00-22:59', '23:00-23:59','00:00-00:59', '01:00-01:59', '02:00-02:59', '03:00-03:59', '04:00-04:59', '05:00-05:59']},";
            $data .= "yAxis: {title: {text: 'Productivity Hourly '}},series: [";

            foreach ($data_summary_inventory_by_date as $row) {
                $data .= "{name: '$row->CHR_WORK_CENTER',data: [";
                $data .= $row->AM_06 . ',' . $row->AM_07 . ',' . $row->AM_08 . ',' . $row->AM_09 . ',' . $row->AM_10 . ',' . $row->AM_11 . ',' . $row->AM_12 . ',' . $row->AM_13 . ',' . $row->AM_14 . ',' . $row->AM_15 . ',' . $row->AM_16 . ',' . $row->AM_17 . ',' . $row->AM_18 . ',' . $row->AM_19 . ',' . $row->AM_20 . ',' . $row->AM_21 . ',' . $row->AM_22 . ',' . $row->AM_23 . ',' . $row->PM_00 . ',' . $row->PM_01 . ',' . $row->PM_02 . ',' . $row->PM_03 . ',' . $row->PM_04 . ',' . $row->PM_05;
                $data .= "], 
               color: '#4DD889', click: onClickDetail}";
            }

            $data .= "] ";
            $data .= "}); });";
            $data .= " function onClickDetail(e) { alert('hallo'); } </script>";

            echo $data;
        }
    }

}
