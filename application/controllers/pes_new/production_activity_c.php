<?php

class Production_activity_c extends CI_Controller {

    private $layout_blank = '/template/head_blank';
    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/production_activity_m');
        $this->load->model('pes/line_stop_prod_m');
        $this->load->model('display_prod/feedback_recovery_prod_m');
    }

    public function index($date = null, $work_center = null) {

        $data['title'] = 'Production Activity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(83);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/production_detail_activity_v.php';

        if($work_center == null || $work_center == ''){
            $where_wc = "";
        }else{
            $where_wc = "AND CHR_WORK_CENTER = '$work_center'";
        }

        $data['data'] = $this->production_activity_m->get_data_production_activity_by_date($date,$where_wc);
        $data['data_detail'] = $this->production_activity_m->get_data_production_activity_detail_by_date($date, $work_center);
        $data['data_ls'] = $this->line_stop_prod_m->get_detail_line_stop_by_wc_and_date($date,$work_center);
        $data['data_comment'] = $this->feedback_recovery_prod_m->get_data_by_workcenter_and_date($work_center, $date); 

        $data['date'] = $date;
        $data['work_center'] = $work_center;
    
        $this->load->view($this->layout, $data);
    }

    public function prod_activity_summary(){

        $date = $this->input->post('CHR_DATE');
        if(!$date){
            $date = date('Ymd');
        }
         
        $data['date'] = $date;
        $data['threshold'] = 90;

        $data['data_eff_per_group_date_up'] = $this->production_activity_m->get_data_efficiency_per_group_by_date(1, $date);
        $data['data_eff_per_group_date_bp'] = $this->production_activity_m->get_data_efficiency_per_group_by_date(2, $date);
        $data['data_eff_per_group_date_dl'] = $this->production_activity_m->get_data_efficiency_per_group_by_date(3, $date);
        $data['data_eff_per_group_date_dr'] = $this->production_activity_m->get_data_efficiency_per_group_by_date(4, $date);
        $data['data_eff_per_group_date_mg'] = $this->production_activity_m->get_data_efficiency_per_group_by_date(5, $date);

        $data['title'] = 'Production Activity Summary';
        $data['content'] = 'pes_new/production_activity_summary_v';
        
        $this->load->view($this->layout_blank, $data);
    }

    public function get_data_by_work_center_and_date(){
        $this->load->model('prd/ng_m');

        $work_center = trim($this->input->post('CHR_WORK_CENTER'));
        $date = trim($this->input->post('CHR_DATE'));
        $list_comment = "";
        $list_ud = "";
        $list_pd = "";
        $list_bd = "";
        $total_bd = "";
        $data_pd = "";
        $data_bd = "";
        $list_ng = "";

        $data_comment = $this->feedback_recovery_prod_m->get_data_by_workcenter_and_date($work_center, $date);       
        $data_line_stop = $this->line_stop_prod_m->get_line_stop_by_wc_and_date($work_center, $date);
        $data_ng = $this->ng_m->get_data_ng_by_work_center_and_date($work_center, $date);
        $data_percentage = $this->production_activity_m->get_percentage_activities($work_center, $date);

        $data_all_time = $this->production_activity_m->get_activity_all_time($work_center, $date);
        $data_availability = $this->production_activity_m->get_activity_availability($work_center, $date);
        $data_performance = $this->production_activity_m->get_activity_performance($work_center, $date);
        $data_quality = $this->production_activity_m->get_activity_quality($work_center, $date);

        if($data_line_stop){
            $list_ud .= "<table style='font-size:13px;' class='table table-striped table-hover table-condensed display' cellspacing='0' width='50%'>";
            $list_ud .= "<thead>";
            $list_ud .= "<tr>"; 
            $list_ud .= "<th style='text-align:left;padding-left:12%;'>Others Loss</th>";
            $list_ud .= "<th style='text-align:center;'>Duration (m)</th>";
            $list_ud .= "</tr>";
            $list_ud .= "</thead>";
            $list_ud .= "<tbody>";
    
            $i = 1;
            $k = 1;
            $tot_ls = 0;
            $tot_bd = 0;
            foreach ($data_line_stop as $isi) {
                if($isi->TOTAL_LINE_STOP > 0){
                    if(trim($isi->CHR_LINE_CODE) != 'LS14' && trim($isi->CHR_LINE_CODE) != 'LS4' && trim($isi->CHR_LINE_CODE) != 'LS5' && trim($isi->CHR_LINE_CODE) != 'LS24' && trim($isi->CHR_LINE_CODE) != 'LS23'){
                        $list_ud .="<tr class='gradeX'>";
                        $list_ud .="<td style='text-align:left;padding-left:12%;'>$isi->CHR_LINE_STOP</td>";
                        $list_ud .="<td style='text-align:center;'>$isi->TOTAL_LINE_STOP</td>";
                        $list_ud .="</tr>";
                        $i++;
                        $tot_ls = $tot_ls + $isi->TOTAL_LINE_STOP;
                    } else if(trim($isi->CHR_LINE_CODE) == 'LS14'){
                        $data_pd .="<tr class='gradeX'>";
                        $data_pd .="<td style='text-align:left;padding-left:12%;background:#DDDDDD;'>$isi->CHR_LINE_STOP</td>";
                        $data_pd .="<td style='text-align:center;background:#DDDDDD;'>$isi->TOTAL_LINE_STOP</td>";
                        $data_pd .="</tr>";
                    } else {
                        $data_bd .="<tr class='gradeX'>";
                        $data_bd .="<td style='text-align:left;padding-left:12%;'>$isi->CHR_LINE_STOP</td>";
                        $data_bd .="<td style='text-align:center;'>$isi->TOTAL_LINE_STOP</td>";
                        $data_bd .="</tr>";
                        $k++;
                        $tot_bd = $tot_bd + $isi->TOTAL_LINE_STOP;
                    }                    
                }
            }
        
            if($tot_ls > 0){
                $list_ud .="<tr>";
                $list_ud .="<td style='text-align:left;padding-left:12%;background:#DDDDDD;'><strong>Total Others</strong></td>";
                $list_ud .="<td style='text-align:center;background:#DDDDDD;'><strong>$tot_ls</strong></td>";
                $list_ud .="</tr>";
            }

            if($tot_bd > 0){
                $total_bd .="<tr>";
                $total_bd .="<td style='text-align:left;padding-left:12%;background:#DDDDDD;'><strong>Total Failure</strong></td>";
                $total_bd .="<td style='text-align:center;background:#DDDDDD;'><strong>$tot_bd</strong></td>";
                $total_bd .="</tr>";
            }
            
            $list_ud .= "</tbody>";
            $list_ud .= "</table>";
    
            if($data_pd != ''){
                $list_pd .= "<table style='font-size:13px;' class='table table-striped table-hover table-condensed display' cellspacing='0' width='50%'>";
                $list_pd .= "<thead>";
                $list_pd .= "<tr>"; 
                $list_pd .= "<th style='text-align:left;padding-left:12%;'>Bridging</th>";
                $list_pd .= "<th style='text-align:center;'>Duration (m)</th>";
                $list_pd .= "</tr>";
                $list_pd .= "</thead>";
                $list_pd .= "<tbody>";
                $list_pd .= $data_pd;
                $list_pd .= "</tbody>";
                $list_pd .= "</table>";
            }

            if($data_bd != ''){
                $list_bd .= "<table style='font-size:13px;' class='table table-striped table-hover table-condensed display' cellspacing='0' width='50%'>";
                $list_bd .= "<thead>";
                $list_bd .= "<tr>"; 
                $list_bd .= "<th style='text-align:left;padding-left:12%;'>Failure Loss</th>";
                $list_bd .= "<th style='text-align:center;'>Duration (m)</th>";
                $list_bd .= "</tr>";
                $list_bd .= "</thead>";
                $list_bd .= "<tbody>";
                $list_bd .= $data_bd;
                $list_bd .= $total_bd;
                $list_bd .= "</tbody>";
                $list_bd .= "</table>";
            }

        }

        if($data_comment){
            $list_comment .= "<table style='font-size:13px;' class='table table-striped table-condensed display' cellspacing='0' width='50%'>";
            $list_comment .= "<thead>";
            $list_comment .= "<tr>"; 
            $list_comment .= "<th style='text-align:left;' >Issue</th>";
            $list_comment .= "<th style='text-align:left;' >C/A</th>";
            // $list_comment .= "<th style='text-align:center;' >Start</th>";
            // $list_comment .= "<th style='text-align:center;' >End</th>";
            $list_comment .= "<th style='text-align:center;' >Duration (m)</th>";
            $list_comment .= "</tr>";
            $list_comment .= "</thead>";
            $list_comment .= "<tbody>";        
    
            $total_duration_problem = 0;
            $i = 1;
            foreach ($data_comment as $isi) {
                $total_duration_problem = $total_duration_problem + $isi->DURATION;
                $list_comment .="<tr class='gradeX'>";
                $list_comment .="<td style='text-align:left;'>$isi->CHR_PROBLEM</td>";
                $list_comment .="<td style='text-align:left;'>$isi->CHR_CORRECTIVE_ACTION</td>";
                // $list_comment .="<td style='text-align:center'>".substr($isi->CHR_START,0,5)."</td>";
                // $list_comment .="<td style='text-align:center'>".substr($isi->CHR_END,0,5)."</td>";
                $list_comment .="<td style='text-align:center'>$isi->DURATION</td>";
                $list_comment .="</td>";
                $list_comment .="</tr>";
                $i++;
            }
    
            if($total_duration_problem > 0){
                $list_comment .="<tr style='background:#DDDDDD;'>";
                $list_comment .="<td colspan='2' style='text-align:center'><strong>Total Line Duration (Minutes)</strong></td>";
                $list_comment .="<td style='text-align:center;'><strong>$total_duration_problem</strong></td>";
                $list_comment .="</tr>";
            }
            
            $list_comment .= "</tbody>";
            $list_comment .= "</table>";
        }

        if($data_ng){
            $list_ng .= "<table style='font-size:13px;' class='table table-striped table-condensed display' cellspacing='0' width='50%'>";
            $list_ng .= "<thead>";
            $list_ng .= "<tr>"; 
            $list_ng .= "<th style='text-align:center;' >Desc</th>";
            $list_ng .= "<th style='text-align:center;' >Back No</th>";
            $list_ng .= "<th style='text-align:center;' >Notes</th>";
            $list_ng .= "<th style='text-align:center;' >Qty Reject</th>";
            $list_ng .= "</tr>";
            $list_ng .= "</thead>";
            $list_ng .= "<tbody>";        
    
            $total_ng = 0;
            $i = 1;
            foreach ($data_ng as $isi) {
                $total_ng = $total_ng + $isi->INT_QTY_NG;
                $list_ng .="<tr class='gradeX'>";
                $list_ng .="<td style='text-align:center;'>$isi->CHR_NG_CATEGORY</td>";
                $list_ng .="<td style='text-align:center'>$isi->CHR_BACK_NO</td>";
                $list_ng .="<td style='text-align:center'>$isi->CHR_NOTES</td>";
                $list_ng .="<td style='text-align:center;'>$isi->INT_QTY_NG</td>";
                $list_ng .="</td>";
                $list_ng .="</tr>";
                $i++;
            }
    
            if($total_ng > 0){
                $list_ng .="<tr style='background:#DDDDDD;'>";
                $list_ng .="<td colspan='3' style='text-align:center'><strong>Total Reject (Qty)</strong></td>";
                $list_ng .="<td style='text-align:center;'><strong>$total_ng</strong></td>";
                $list_ng .="</tr>";
            }
            
            $list_ng .= "</tbody>";
            $list_ng .= "</table>";
        }

        $chart_all_time = "";
        $chart_all_time .= "<script type='text/javascript'>";
        $chart_all_time .= "var chart_all_time;";
        $chart_all_time .= "$(document).ready(function () {";
        $chart_all_time .= "chart_all_time = new Highcharts.Chart({";
        $chart_all_time .= "chart: {
                    height: 300,
                    width:580,
                    plotShadow: false,
                    plotBorderWidth: 1.,
                    type: 'bar',
                    renderTo: 'chart_all_time'
                },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['All Times'],
                labels: {
                    rotation: 270
                }
            },
            yAxis: {
                allowDecimals: true,
                min: 0,
                minorGridLineWidth: 1,
                gridLineWidth: 1,
                title: {
                    text: ''
                }
            },
            tooltip: {
                formatter: function () {
                    return this.series.name + ': ' + this.y + ' Minutes<br/>';
                }
            },
            plotOptions: {
                bar: {
                    stacking: 'normal'
                },
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter:function() {
                            return  this.y + ' Minutes';
                        }
                    }
                }
            },
            credits: {
                    enabled: false
            },
            series: [";

            foreach ($data_all_time as $isi) {
                $chart_all_time .= "{name:'$isi->DESCRIPTION', data: [$isi->DURATION], stack: '$isi->STACK', color: '$isi->COLOR'},";
            }

        $chart_all_time .= "] ";
        $chart_all_time .= "}); chart_all_time.renderer.text('OEE : $data_percentage->INT_OEE %', 300, 40).attr({  zIndex: 5, stroke: 'black', 'stroke-width': 1, }).add(); }); </script>";

        $chart_availability = "";
        $chart_availability .= "<script type='text/javascript'>";
        $chart_availability .= "var chart_availability;";
        $chart_availability .= "$(document).ready(function () {";
        $chart_availability .= "chart_availability = new Highcharts.Chart({";
        $chart_availability .= "chart: {
                    height: 300,
                    width:580,
                    plotShadow: false,
                    plotBorderWidth: 1.,
                    type: 'bar',
                    renderTo: 'chart_availability'
                },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Availability'],
                labels: {
                    rotation: 270
                }
            },
            yAxis: {
                allowDecimals: true,
                min: 0,
                minorGridLineWidth: 1,
                gridLineWidth: 1,
                title: {
                    text: ''
                }
            },
            tooltip: {
                formatter: function () {
                    return this.series.name + ': ' + this.y + ' Minutes<br/>';
                }
            },
            plotOptions: {
                bar: {
                    stacking: 'normal'
                },
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter:function() {
                            return  this.y + ' Minutes';
                        }
                    }
                }
            },
            credits: {
                    enabled: false
            },
            series: [";

            foreach ($data_availability as $isi) {
                $chart_availability .= "{name:'$isi->DESCRIPTION', data: [$isi->DURATION], stack: '$isi->STACK', color: '$isi->COLOR'},";
            }

        $chart_availability .= "] ";
        $chart_availability .= "}); chart_availability.renderer.text('$data_percentage->INT_AVAILABILITY %', 300, 40).attr({  zIndex: 5, stroke: 'black', 'stroke-width': 1, }).add(); }); </script>";

        $chart_performance = "";
        $chart_performance .= "<script type='text/javascript'>";
        $chart_performance .= "var chart_performance;";
        $chart_performance .= "$(document).ready(function () {";
        $chart_performance .= "chart_performance = new Highcharts.Chart({";
        $chart_performance .= "chart: {
                    height: 300,
                    width:580,
                    plotShadow: false,
                    plotBorderWidth: 1.,
                    type: 'bar',
                    renderTo: 'chart_performance'
                },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Performance'],
                labels: {
                    rotation: 270
                }
            },
            yAxis: {
                allowDecimals: true,
                min: 0,
                minorGridLineWidth: 1,
                gridLineWidth: 1,
                title: {
                    text: ''
                }
            },
            tooltip: {
                formatter: function () {
                    return this.series.name + ': ' + this.y + ' Pcs<br/>';
                }
            },
            plotOptions: {
                bar: {
                    stacking: 'normal'
                },
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter:function() {
                            return  this.y + ' Pcs';
                        }
                    }
                }
            },
            credits: {
                    enabled: false
            },
            series: [";

            foreach ($data_performance as $isi) {
                $chart_performance .= "{name:'$isi->DESCRIPTION', data: [$isi->DURATION], stack: '$isi->STACK', color: '$isi->COLOR'},";
            }

        $chart_performance .= "] ";
        $chart_performance .= "}); chart_performance.renderer.text('$data_percentage->INT_PRODUCTIVITY %', 300, 40).attr({  zIndex: 5, stroke: 'black', 'stroke-width': 1, }).add(); }); </script>";

        $chart_quality = "";
        $chart_quality .= "<script type='text/javascript'>";
        $chart_quality .= "var chart_quality;";
        $chart_quality .= "$(document).ready(function () {";
        $chart_quality .= "chart_quality = new Highcharts.Chart({";
        $chart_quality .= "chart: {
                    height: 300,
                    width:580,
                    plotShadow: false,
                    plotBorderWidth: 1.,
                    type: 'bar',
                    renderTo: 'chart_quality'
                },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Quality'],
                labels: {
                    rotation: 270
                }
            },
            yAxis: {
                allowDecimals: true,
                min: 0,
                minorGridLineWidth: 1,
                gridLineWidth: 1,
                title: {
                    text: ''
                }
            },
            tooltip: {
                formatter: function () {
                    return this.series.name + ': ' + this.y + ' Pcs<br/>';
                }
            },
            plotOptions: {
                bar: {
                    stacking: 'normal'
                },
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter:function() {
                            return  this.y + ' Pcs';
                        }
                    }
                }
            },
            credits: {
                    enabled: false
            },
            series: [";

            foreach ($data_quality as $isi) {
                $chart_quality .= "{name:'$isi->DESCRIPTION', data: [$isi->DURATION], stack: '$isi->STACK', color: '$isi->COLOR'},";
            }

        $chart_quality .= "] ";
        $chart_quality .= "}); chart_quality.renderer.text('$data_percentage->INT_QUALITY %', 300, 40).attr({  zIndex: 5, stroke: 'black', 'stroke-width': 1, }).add(); }); </script>";

        $json['list_comment'] = $list_comment;
        $json['list_ud'] = $list_ud;
        $json['list_pd'] = $list_pd;
        $json['list_bd'] = $list_bd;
        $json['list_ng'] = $list_ng;
        $json['chart_all_time'] = $chart_all_time;
        $json['chart_availability'] = $chart_availability;
        $json['chart_performance'] = $chart_performance;
        $json['chart_quality'] = $chart_quality;
        $json['INT_AVAILABILITY'] = $data_percentage->INT_AVAILABILITY;
        $json['INT_PRODUCTIVITY'] = $data_percentage->INT_PRODUCTIVITY;
        $json['INT_QUALITY'] = $data_percentage->INT_QUALITY;
        $json['INT_OEE'] = $data_percentage->INT_OEE;

        if ('IS_AJAX') {
            echo json_encode($json);
        }

    }

    public function summary_act_by_period($period = null){

        $data['title'] = 'Summary Production Activity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(338);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/production_act_v.php';

        if($period == null || $period == ''){
            $period = date('Ym');
        }

        $data['data'] = $this->production_activity_m->get_act_by_period($period);
        $data['period'] = $period;
    
        $this->load->view($this->layout, $data);
    }

    function download_eff_production(){
        $this->load->library('excel');

        $period = $this->input->post('CHR_PERIOD');
        $data = $this->production_activity_m->get_act_by_period($period);

        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load("assets/template/production/eff-template.xls");

        $row = 0;
        $objPHPExcel->getActiveSheet()->setCellValue("P2", "$period");
        foreach ($data as $isi) {

            switch ($isi->CHR_WORK_CENTER) {
                case "ASDF01":
                    $row = 4;
                    break;
                case "ASDF02":
                    $row = 5;
                    break;
                case "ASDF03":
                    $row = 6;
                    break;
                case "ASDF04":
                    $row = 7;
                    break;
                case "ASDF05":
                    $row = 8;
                    break;
                case "ASDF06":
                    $row = 9;
                    break;
                case "ASDF07":
                    $row = 10;
                    break;
                case "ASDF08":
                    $row = 11;
                    break;
                case "ASDF09":
                    $row = 12;
                    break;
                case "ASDF10":
                    $row = 13;
                    break;
                case "ASCA01":
                    $row = 16;
                    break;
                case "ASCA02":
                    $row = 17;
                    break;
                case "ASDH01":
                    $row = 18;
                    break;
                case "ASDH02":
                    $row = 19;
                    break;
                case "ASHL01":
                    $row = 20;
                    break;
                case "ASHL02":
                    $row = 21;
                    break;
                case "ASRH01":
                    $row = 22;
                    break;
                case "ASDL03":
                    $row = 24;
                    break;
                case "ASDL04":
                    $row = 25;
                    break;
                case "ASDL05":
                    $row = 26;
                    break;
                case "ASDL07":
                    $row = 27;
                    break;
                case "ASDL08":
                    $row = 28;
                    break;
                case "ASDL09":
                    $row = 29;
                    break;
                case "ASDL10":
                    $row = 30;
                    break;
                case "ASDL12":
                    $row = 31;
                    break;
                case "ASDL13":
                    $row = 32;
                    break;
                case "ASCC01":
                    $row = 34;
                    break;
                case "ASCC02":
                    $row = 35;
                    break;
                case "ASCC03":
                    $row = 36;
                    break;
                case "ASCC04":
                    $row = 37;
                    break;
                case "ASCC05":
                    $row = 38;
                    break;
                case "ASCD01":
                    $row = 40;
                    break;
                case "ASCD02":
                    $row = 41;
                    break;
                case "ASCD03":
                    $row = 42;
                    break;
                case "ASCH01":
                    $row = 44;
                    break;
                case "ASIM01":
                    $row = 45;
                    break;
                case "ASIM02":
                    $row = 46;
                    break;
                case "ASIM03":
                    $row = 47;
                    break;
                case "ASIM04":
                    $row = 48;
                    break;
                case "PC001A":
                    $row = 50;
                    break;
                case "PC001B":
                    $row = 51;
                    break;
                case "PC001C":
                    $row = 52;
                    break;
                case "PC001D":
                    $row = 53;
                    break;
                case "PC003A":
                    $row = 54;
                    break;
                case "PC003B":
                    $row = 55;
                    break;
                case "PC003C":
                    $row = 56;
                    break;
                case "PC003D":
                    $row = 57;
                    break;
                case "PC003E":
                    $row = 58;
                    break;
                case "PC003F":
                    $row = 59;
                    break;
                case "PC003G":
                    $row = 60;
                    break;
                case "PC003I":
                    $row = 61;
                    break;
                case "PR001A":
                    $row = 63;
                    break;
                case "PR001B":
                    $row = 64;
                    break;
                case "PR002A":
                    $row = 65;
                    break;
                case "PR002B":
                    $row = 66;
                    break;
                case "PR002C":
                    $row = 67;
                    break;
                case "PR002D":
                    $row = 68;
                    break;
                case "PR002E":
                    $row = 69;
                    break;
                case "PR003A":
                    $row = 70;
                    break;
                case "PR003B":
                    $row = 71;
                    break;
                case "PR003C":
                    $row = 72;
                    break;
                case "PR004C":
                    $row = 73;
                    break;
                case "PR005B":
                    $row = 74;
                    break;
                case "PR006I":
                    $row = 75;
                    break;
                case "PR006Q":
                    $row = 76;
                    break;
                case "PR007C":
                    $row = 77;
                    break;
                case "PR008B":
                    $row = 78;
                    break;
                case "PR009B":
                    $row = 79;
                    break;
                case "WEDF01":
                    $row = 81;
                    break;
                case "WEDF04":
                    $row = 82;
                    break;
                case "WEDF08":
                    $row = 83;
                    break;
                case "WEDF10":
                    $row = 85;
                    break;
                case "WEDF15":
                    $row = 88;
                    break;
                case "WECR02":
                    $row = 89;
                    break;
                case "RFDF01":
                    $row = 109;
                    break;
                case "RFDF02":
                    $row = 110;
                    break;
                case "RFDF03":
                    $row = 111;
                    break;
                case "RFDF04":
                    $row = 112;
                    break;
                case "RFDF05":
                    $row = 113;
                    break;
                case "SACC02":
                    $row = 122;
                    break;
                case "HTDS01":
                    $row = 126;
                    break;
                case "HTDS02":
                    $row = 127;
                    break;
                case "MADS01":
                    $row = 128;
                    break;
                case "MADS02":
                    $row = 129;
                    break;
                case "MADS03":
                    $row = 130;
                    break;
                case "MADS04":
                    $row = 131;
                    break;
                case "HTCD01":
                    $row = 133;
                    break;
                case "HTST01":
                    $row = 134;
                    break;
                default:
                    $row = 0;
            }

            $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$isi->INT_PRODUCTION_TIME");
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$isi->INT_UNPLANNED_DOWNTIME");
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$isi->INT_TOTAL_OK");
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$isi->INT_TOTAL_NG");
        }

        ob_end_clean();
        $filename = "eff_production_$period.xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');

    }

}

