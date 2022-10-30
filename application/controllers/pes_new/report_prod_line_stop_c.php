<?php

class Report_prod_line_stop_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes_new/production_result_m');
        $this->load->model('pes/production_activity_m');
        $this->load->model('display_prod/feedback_recovery_prod_m');
    }

    public function index($date = null) {

        $data['title'] = 'Report Line Stop';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(130);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_prod_line_stop_v';
        $date_fix = date('d-m-Y');
        $data['date'] = $date_fix;
        $shift = 1;
        $data['shift'] =  $shift;

        $date = substr($date_fix, 6, 4) . substr($date_fix, 3, 2)  . substr($date_fix, 0, 2);

        $data['all_shift'] = $this->production_result_m->get_shift();
        $data['data'] = $this->production_result_m->select_data_prod_line_stop($date, $shift);
        $data['data_detail'] = $this->production_result_m->select_data_prod_line_stop_detail($date, $shift);

        $data['data_issue'] = $this->feedback_recovery_prod_m->get_all_data_problem_and_recovery($date);

        $this->load->view($this->layout, $data);
    }

    function search_prod_part(){

        $date_fix = $this->input->post('CHR_DATE');
        $shift = $this->input->post('CHR_SHIFT');

        $data['title'] = 'Report Line Stop';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(130);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_prod_line_stop_v';

        $data['date'] = $date_fix;
        $data['shift'] = $shift;

        $date = substr($date_fix, 6, 4) . substr($date_fix, 3, 2)  . substr($date_fix, 0, 2);

        $data['all_shift'] = $this->production_result_m->get_shift();
        $data['data'] = $this->production_result_m->select_data_prod_line_stop($date, $shift);
        $data['data_detail'] = $this->production_result_m->select_data_prod_line_stop_detail($date, $shift);

        $data['data_issue'] = $this->feedback_recovery_prod_m->get_all_data_problem_and_recovery($date);

        $this->load->view($this->layout, $data);
    }

    function get_efficiency_prod_per_group(){

        $date = $this->input->post('CHR_DATE');
        if(!$date){
            $date = date('Ymd');
        }
         
        $period = substr($date,0,6);
        $data['date'] = $date;
        $data['threshold'] = 90;

        $data['data_eff_per_group_date_up'] = $this->production_result_m->get_data_efficiency_per_group_by_date(1, $date);
        $data['data_eff_per_group_date_bp'] = $this->production_result_m->get_data_efficiency_per_group_by_date(2, $date);
        $data['data_eff_per_group_date_dl'] = $this->production_result_m->get_data_efficiency_per_group_by_date(3, $date);
        $data['data_eff_per_group_date_dr'] = $this->production_result_m->get_data_efficiency_per_group_by_date(4, $date);
        $data['data_eff_per_group_date_mg'] = $this->production_result_m->get_data_efficiency_per_group_by_date(5, $date);

        $data['data_issue'] = $this->feedback_recovery_prod_m->get_all_data_problem_and_recovery($date);

        $data['data_eff_per_group_and_period_up'] = $this->production_result_m->get_efficiency_per_group_and_period(1, $period);
        $data['data_eff_per_group_and_period_bp'] = $this->production_result_m->get_efficiency_per_group_and_period(2, $period);
        $data['data_eff_per_group_and_period_dl'] = $this->production_result_m->get_efficiency_per_group_and_period(3, $period);
        $data['data_eff_per_group_and_period_dr'] = $this->production_result_m->get_efficiency_per_group_and_period(4, $period);
        $data['data_eff_per_group_and_period_mg'] = $this->production_result_m->get_efficiency_per_group_and_period(5, $period);

        $data['title'] = 'Production Performance';
        $data['content'] = 'pes_new/prod_eff_per_group_v';
        
        $this->load->view($this->layout_blank, $data);
    }

    function test(){
        $total_work_time = $this->production_activity_m->get_duration_activity_production('ASDL12', '20200616');
        echo  $total_work_time;
    }

    function get_data_by_work_center_and_date(){
        $work_center = trim($this->input->post('CHR_WORK_CENTER'));
        $date = trim($this->input->post('CHR_DATE'));

        $data_comment = $this->feedback_recovery_prod_m->get_data_by_workcenter_and_date($work_center, $date);       
        $data_line_stop = $this->feedback_recovery_prod_m->get_data_line_stop_by_workcenter_and_date($work_center, $date);
        $chart_percentage_eff = $this->feedback_recovery_prod_m->get_chart_percentage_per_work_center($work_center, $date);
        $total_work_time = $this->production_activity_m->get_duration_activity_production($work_center, $date);

        if($date == date('Ymd'))
        {
            $total_work_time = '-';
        }

        $data = "";
        $data2 = "";        

        $data .= "<div class='form-group'>";
        $data .= "<table style='font-size:13px;' class='table table-striped table-condensed display' cellspacing='0' width='100%'>";
        $data .= "<thead>";
        $data .= "<tr>"; 
        $data .= "<th style='text-align:center;' >No</th>";
        $data .= "<th style='text-align:left;' >Issue</th>";
        $data .= "<th style='text-align:left;' >Corrective Action</th>";
        $data .= "<th style='text-align:center;' >Start Time</th>";
        $data .= "<th style='text-align:center;' >End Time</th>";
        $data .= "<th style='text-align:center;' >Duration (Minutes)</th>";
        $data .= "</tr>";
        $data .= "</thead>";
        $data .= "<tbody>";        

        $total_duration_problem = 0;
            $i = 1;
            foreach ($data_comment as $isi) {
                $total_duration_problem = $total_duration_problem + $isi->DURATION;
                $data .="<tr class='gradeX'>";
                $data .="<td style='text-align:center'>$i</td>";
                $data .="<td style='text-align:left;'>$isi->CHR_PROBLEM</td>";
                $data .="<td style='text-align:left;'>$isi->CHR_CORRECTIVE_ACTION</td>";
                $data .="<td style='text-align:center'>".substr($isi->CHR_START,0,5)."</td>";
                $data .="<td style='text-align:center'>".substr($isi->CHR_END,0,5)."</td>";
                $data .="<td style='text-align:center'>$isi->DURATION</td>";
                $data .="</td>";
                $data .="</tr>";
                $i++;
            }

            if($total_duration_problem > 0){
                $data .="<tr style='background:#DDDDDD;'>";
                $data .="<td colspan='5' style='text-align:center'><strong>Total Line Duration (Minutes)</strong></td>";
                $data .="<td style='text-align:center;'><strong>$total_duration_problem</strong></td>";
                $data .="</tr>";
            }
        
        $data .= "</tbody>";
        $data .= "</table>";
            
        $data .= "&nbsp;";
        $data .= "<table style='font-size:13px;' class='table table-striped table-condensed display' cellspacing='0' width='100%'>";
        $data .= "<thead>";
        $data .= "<tr>"; 
        $data .= "<th style='text-align:center;' >No</th>";
        $data .= "<th style='text-align:left;' >Line Stop</th>";
        $data .= "<th colspan='2' style='text-align:center;' >Duration (Minutes)</th>";
        $data .= "</tr>";
        $data .= "</thead>";
        $data .= "<tbody>";

            $i = 1;
            $tot_ls = 0;
            foreach ($data_line_stop as $isi) {
                if($isi->TOTAL_LINE_STOP > 0){
                    if(trim($isi->CHR_LINE_CODE) != 'LS14'){
                        $data .="<tr class='gradeX'>";
                        $data .="<td style='text-align:center'>$i</td>";
                        $data .="<td style='text-align:left;'>$isi->CHR_LINE_STOP</td>";
                        $data .="<td style='text-align:center;'>$isi->TOTAL_LINE_STOP</td>";
                        $data .="<td></td>";
                        $data .="</tr>";
                        $i++;
                        $tot_ls = $tot_ls + $isi->TOTAL_LINE_STOP;
                    } else {
                        $data2 .="<tr class='gradeX'>";
                        $data2 .="<td style='text-align:center'></td>";
                        $data2 .="<td style='text-align:left;'>$isi->CHR_LINE_STOP</td>";
                        $data2 .="<td></td>";
                        $data2 .="<td style='text-align:center;'>$isi->TOTAL_LINE_STOP</td>";
                        $data2 .="</tr>";
                    }                    
                }
            }
        
            if($tot_ls > 0){
                $data .="<tr>";
                $data .="<td colspan='3' style='text-align:center;background:#DDDDDD;'><strong>Total Line Stop (Minutes)</strong></td>";
                $data .="<td style='text-align:center;background:#DDDDDD;'><strong>$tot_ls</strong></td>";
                $data .="</tr>";
            }
        
        $data .= $data2;
        $data .= "</tbody>";
        $data .= "</table>";

        $data .= "</div>"; 


        $data_chart = "";

        $data_chart .= "<script type='text/javascript'>";
        $data_chart .= "var chart6;";
        $data_chart .= "$(document).ready(function () {";
        $data_chart .= "chart6 = new Highcharts.Chart({";
        $data_chart .= "chart: {
                    height: 300,
                    width:580,
                    type: 'column',
                    renderTo: 'detail_chart2'
                },
            title: {
                text: 'Detail Efficiency'
            },
            subtitle: {
                text: 'Loading Time (Work Time - Bridging) : $total_work_time (Minutes)' ,
                align: 'right'
            },
            credits: {
                    enabled: false
            },
            xAxis: {
                categories: ['$work_center']
            },
            yAxis: {
               title: {
                   text: 'Percentage (%)'
               }
           },
            legend: {
                enabled: true
            },
            tooltip: {
                headerFormat: '<span>{series.name}</span><br>',
                pointFormat: '<span>{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },
            
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
    
            series: [";

            foreach ($chart_percentage_eff as $isi) {
                $data_chart .= "{name:'$isi->CHR_CATEGORY', data: [$isi->CHR_PERC]},";
            }
                        

        $data_chart .= " ] }); }); </script>";

        $json['data'] = $data;
        $json['data_chart'] = $data_chart;

        if ('IS_AJAX') {
            echo json_encode($json);
        }

    }

}

