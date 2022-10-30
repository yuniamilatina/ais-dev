<?php 
    header("Content-type: text/html; charset=iso-8859-1"); 
    $bgt_aii = $this->load->database("bgt_aii", TRUE);
    
    $new_bgt_type = '';
    if($bgt_type == 'ALL'){
        $new_bgt_type = '';
    } else {
        $new_bgt_type = $bgt_type;
    }
?>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<style>
#filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

div.scrollmenu {
    overflow: auto;
    white-space: nowrap;
    font-size: 11px;
}

</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Report Summary Budget</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
<script type="text/javascript">
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer",
                {
                    theme: "theme2",
                    animationEnabled: true,
                    title: {
                        text: "",
                        fontSize: 20
                    },
                    toolTip: {
                        shared: true
                    },
                    axisY: {
                        title: "AMOUNT (*1Juta)",
                        gridThickness: 0.2,
                        interval: 10000
                    },
                    axisX: {
                        gridThickness:0,
                        labelFontSize: 14,
                        interval: 1                                        
                    },
                    data: [
                        {
                            type: "column",
                            indexLabelPlacement: "outside",
                            indexLabelFontSize: 10,
                            indexLabelFontColor: "black",
                            indexLabelFontWeight: "bold",
                            indexLabelOrientation: "horizontal",                                            
                            name: "PLAN",
                            legendText: "PLAN",
                            showInLegend: true,
                            dataPoints: [
<?php
$count_budget = count($data_report_gm);
$tot_plan_group = 0;
$row_plan = 1;
if($act_periode < $periode_smt2){
    //PLAN BEFORE REVISE BUDGET
    foreach ($data_report_gm as $bgt) {
        if ($row_plan == $count_budget) {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($bgt->TOT_PLAN / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_PLAN / 1000000000,2) . ' bio"}';
        } else {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($bgt->TOT_PLAN / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_PLAN / 1000000000,2) . ' bio"},';
        }
        $tot_plan_group = $tot_plan_group + $bgt->TOT_PLAN;
        $row_plan++;
    }
} else {
    //PLAN AFTER REVISE BUDGET
    foreach ($data_report_gm as $bgt) {
        $plan = $this->report_budget_m->get_new_budget_detail($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT);
        if ($plan){
            $tot_plan = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
        }else{
            $tot_plan = 0;
        }
        //add by bugsmaker
        //$tot_plan = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
        if ($row_plan == $count_budget) {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_plan / 1000000,2) . ', indexLabel:"' . round($tot_plan / 1000000000,2) . '"}';
        } else {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_plan / 1000000,2) . ', indexLabel:"' . round($tot_plan / 1000000000,2) . '"},';
        }

        $tot_plan_group = $tot_plan_group + $tot_plan;
        $row_plan++;
    }
}
?>
                        
                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "REVISE",
                                legendText: "REVISE",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_gm);
$tot_rev_group = 0;
$row_rev = 1;
foreach ($data_report_gm as $bgt) {
    
    $plan = $this->report_budget_m->get_new_budget_detail_rev($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT);
    if($act_periode < $periode_smt2){
        //BEFORE REVISE BUDGET
        $tot_rev = 0;
    } else {
        //AFTER REVISE BUDGET
        if ($plan){
            $tot_rev = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
        } else {
            $tot_rev = 0;
        }
    }
    //add by bugsmaker
    //$tot_rev = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
    if ($row_rev == $count_budget) {
        echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_rev / 1000000,2) . ', indexLabel:"' . round($tot_rev / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_rev / 1000000,2) . ', indexLabel:"' . round($tot_rev / 1000000000,2) . '"},';
    }
    
    $tot_rev_group = $tot_rev_group + $tot_rev;
    $row_rev++;
}
?> 
                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "LIMIT",
                                legendText: "LIMIT",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_gm);
$tot_limit_group = 0;
$row_lim = 1;
if($act_periode < $periode_smt2){
    //LIMIT BEFORE REVISE BUDGET
    foreach ($data_report_gm as $bgt) {
        if ($row_lim == $count_budget) {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($bgt->TOT_LIMIT / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_LIMIT / 1000000000,2) . ' bio"}';
        } else {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($bgt->TOT_LIMIT / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_LIMIT / 1000000000,2) . ' bio"},';
        }
        $tot_limit_group = $tot_limit_group + $bgt->TOT_LIMIT;
        $row_lim++;
    }
} else {
    //LIMIT AFTER REVISE BUDGET
    foreach ($data_report_gm as $bgt) {

        $revise = $this->report_budget_m->get_new_budget_detail_rev($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT);
        if ($revise){
            $tot_rev = $revise->PBLN04 + $revise->PBLN05 + $revise->PBLN06 + $revise->PBLN07 + $revise->PBLN08 + $revise->PBLN09 + $revise->PBLN10 + $revise->PBLN11 + $revise->PBLN12 + $revise->PBLN13 + $revise->PBLN14 + $revise->PBLN15;
        }else{
            $tot_rev = 0;
        }
        //add by bugsmaker
        //$tot_rev = $revise->PBLN04 + $revise->PBLN05 + $revise->PBLN06 + $revise->PBLN07 + $revise->PBLN08 + $revise->PBLN09 + $revise->PBLN10 + $revise->PBLN11 + $revise->PBLN12 + $revise->PBLN13 + $revise->PBLN14 + $revise->PBLN15;
        if ($row_lim == $count_budget) {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round(($tot_rev*(70/100)) / 1000000,2) . ', indexLabel:"' . round(($tot_rev*(70/100)) / 1000000000,2) . '"}';
        } else {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round(($tot_rev*(70/100)) / 1000000,2) . ', indexLabel:"' . round(($tot_rev*(70/100)) / 1000000000,2) . '"},';
        }

        $tot_limit_group = $tot_limit_group + ($tot_rev*(70/100));
        $row_lim++;
    }
}
?> 
                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "ACTUAL PR",
                                legendText: "ACTUAL PR",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_gm);
$tot_act_group = 0;
$row_act = 1;
if($act_periode < $periode_smt2){
    //ACTUAL PR BEFORE REVISE BUDGET
    foreach ($data_report_gm as $bgt) {
        if ($row_act == $count_budget) {        
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($bgt->TOT_ACTUAL / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_ACTUAL / 1000000000,2) . ' bio"}';
        } else {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($bgt->TOT_ACTUAL / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_ACTUAL / 1000000000,2) . ' bio"},';
        }
        $tot_act_group = $tot_act_group + $bgt->TOT_ACTUAL;
        $row_act++;
    }
} else {
    //ACTUAL PR AFTER REVISE BUDGET
    foreach ($data_report_gm as $bgt) {

        $pr = $this->report_budget_m->get_new_actual_real($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT);
        if ($pr){
            $tot_pr = $pr->OPRBLN04 + $pr->OPRBLN05 + $pr->OPRBLN06 + $pr->OPRBLN07 + $pr->OPRBLN08 + $pr->OPRBLN09 + $pr->OPRBLN10 + $pr->OPRBLN11 + $pr->OPRBLN12 + $pr->OPRBLN13 + $pr->OPRBLN14 + $pr->OPRBLN15;
        } else  {
            $tot_pr = 0;
        }
        //add by bugsmaker
        //$tot_pr = $pr->OPRBLN04 + $pr->OPRBLN05 + $pr->OPRBLN06 + $pr->OPRBLN07 + $pr->OPRBLN08 + $pr->OPRBLN09 + $pr->OPRBLN10 + $pr->OPRBLN11 + $pr->OPRBLN12 + $pr->OPRBLN13 + $pr->OPRBLN14 + $pr->OPRBLN15;
        if ($row_act == $count_budget) {        
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_pr / 1000000,2) . ', indexLabel:"' . round($tot_pr / 1000000000,2) . '"}';
        } else {
            echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_pr / 1000000,2) . ', indexLabel:"' . round($tot_pr / 1000000000,2) . '"},';
        }

        $tot_act_group = $tot_act_group + $tot_pr;
        $row_act++;
    }
}
?>
                                                                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "ACTUAL GR",
                                legendText: "ACTUAL GR",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_gm);
$tot_gr_group = 0;
$row_act = 1;
foreach ($data_report_gm as $bgt) {
    if ($bgt_type == 'CAPEX'){
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_capex_chart_dept '$fiscal_start', '$fiscal_end' , '".$bgt->CHR_KODE_GROUP."', '".$bgt->CHR_KODE_DEPARTMENT."', ''");
    } else {
        if($bgt_type == 'ALL'){
            $new_bgt_type = '';
        } else {
            $new_bgt_type = $bgt_type;
        }
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_expense_chart_dept '$fiscal_start', '$fiscal_end' , '$new_bgt_type' , '".$bgt->CHR_KODE_GROUP."', '".$bgt->CHR_KODE_DEPARTMENT."', ''");
    }
    
    if($data_gr->num_rows() == 0){
        $tot_gr = 0;
    } else {
        $tot_gr = $data_gr->row()->TOT_GR;
    }
    
    
    if ($row_act == $count_budget) {        
        echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_gr / 1000000,2) . ', indexLabel:"' . round($tot_gr / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_DEPARTMENT . '", y:' . round($tot_gr / 1000000,2) . ', indexLabel:"' . round($tot_gr / 1000000000,2) . '"},';
    }
    $tot_gr_group = $tot_gr_group + $tot_gr;
    $row_act++;
}
?>
                        ]
                            }

                        ],
                        legend: {
//                            cursor: "pointer",
//                            itemclick: function(e) {
//                                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
//                                    e.dataSeries.visible = false;
//                                }
//                                else {
//                                    e.dataSeries.visible = true;
//                                }
//                                chart.render();
//                            }
                        }
                    });
                    
            var chart_2 = new CanvasJS.Chart("chartContainer_2",
                {
                    theme: "theme2",
                    animationEnabled: true,
                    title: {
                        text: "",
                        fontSize: 30
                    },
                    toolTip: {
                        shared: true
                    },
                    axisY: {
                        title: "AMOUNT (/1Juta)",
                        gridThickness:0.2,
                        interval: 10000
                    },
                    axisX: {
                        gridThickness:0,
                        labelFontSize: 14,
                        interval: 1                                        
                    },
                    data: [
                        {
                            type: "column",
                            indexLabelPlacement: "outside",
                            indexLabelFontSize: 10,
                            indexLabelFontColor: "black",
                            indexLabelFontWeight: "bold",
                            indexLabelOrientation: "horizontal",                                           
                            name: "PLAN",
                            legendText: "PLAN",
                            showInLegend: true,
                            dataPoints: [
<?php
$count_budget = count($data_report_man);
$row_plan = 1;
//BEFORE REVISE BUDGET
foreach ($data_report_man as $bgt) {
    if ($row_plan == $count_budget) {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_PLAN / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_PLAN / 1000000000,2) . ' bio"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_PLAN / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_PLAN / 1000000000,2) . ' bio"},';
    }
    $row_plan++;
}
?>
                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "LIMIT",
                                legendText: "LIMIT",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_man);
$row_lim = 1;
foreach ($data_report_man as $bgt) {
    if ($row_lim == $count_budget) {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_LIMIT / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_LIMIT / 1000000000,2) . ' bio"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_LIMIT / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_LIMIT / 1000000000,2) . ' bio"},';
    }
    $row_lim++;
}
?> 
                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "ACTUAL",
                                legendText: "ACTUAL",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_man);
$row_act = 1;
foreach ($data_report_man as $bgt) {
    if ($row_act == $count_budget) {        
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_ACTUAL / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_ACTUAL / 1000000000,2) . ' bio"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_ACTUAL / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_ACTUAL / 1000000000,2) . ' bio"},';
    }
    $row_act++;
}
?>
                        ]
                            },
                            {
                                type: "column",
                                indexLabelPlacement: "outside",
                                indexLabelFontSize: 10,
                                indexLabelFontColor: "black",
                                indexLabelFontWeight: "bold",
                                indexLabelOrientation: "horizontal",
                                name: "ACTUAL GR",
                                legendText: "ACTUAL GR",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_man);
$row_act = 1;
foreach ($data_report_man as $bgt) {
    if ($bgt_type == 'CAPEX'){
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_capex_chart_sect '$fiscal_start', '$fiscal_end' , '".$bgt->CHR_KODE_DEPARTMENT."', '".$bgt->CHR_KODE_SECTION."', ''");
    } else {
        if($bgt_type == 'ALL'){
            $new_bgt_type = '';
        } else {
            $new_bgt_type = $bgt_type;
        }
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_expense_chart_sect '$fiscal_start', '$fiscal_end' , '$new_bgt_type' , '".$bgt->CHR_KODE_DEPARTMENT."', '".$bgt->CHR_KODE_SECTION."', ''");
    }
    
    if($data_gr->num_rows() == 0){
        $tot_gr = 0;
    } else {
        $tot_gr = $data_gr->row()->TOT_GR;
    }
    
    
    if ($row_act == $count_budget) {        
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_gr / 1000000,2) . ', indexLabel:"' . round($tot_gr / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_gr / 1000000,2) . ', indexLabel:"' . round($tot_gr / 1000000000,2) . '"},';
    }
    $row_act++;
}
?>
                        ]
                            }

                        ],
                        legend: {
//                            cursor: "pointer",
//                            itemclick: function(e) {
//                                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
//                                    e.dataSeries.visible = false;
//                                }
//                                else {
//                                    e.dataSeries.visible = true;
//                                }
//                                chart.render();
//                            }
                        }
                    });

            chart.render();
            chart_2.render();
        }
                </script>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REPORT BUDGET BY DEPT - <?php echo $bgt_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id="filter">
                                <tr>
                                    <td width="10%">Fiscal Year</td>
                                    <td width="20%">
                                        <select name="CHR_FISCAL_YEAR" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($data_fiscal as $data) { ?>
                                                <option value="<?PHP echo site_url('budget/report_budget_c/report_budget_for_gm/' . $data->CHR_FISCAL_YEAR_START . '/' . $bgt_type . '/' . $kode_group . '/' . $kode_dept); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%">Group Dept</td>
                                    <td width="20%">
                                        <?php if($role == '4'){ ?>
                                            <select name="CHR_GROUP" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;" disabled>
                                        <?php } else { ?>
                                            <select name="CHR_GROUP" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;">    
                                        <?php } ?>    
                                            <option value='<?php echo site_url('budget/report_budget_c/report_budget_for_gm/' . $fiscal_start . '/' . $bgt_type . '/ALL/' . $kode_dept); ?>'>ALL</option>
                                            <?php foreach ($list_group as $group) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_budget_for_gm/' . $fiscal_start . '/' . $bgt_type . '/' . trim($group->CHR_KODE_GROUP) . '/' . $kode_dept); ?>" <?php
                                                if ($kode_group == trim($group->CHR_KODE_GROUP)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($group->CHR_KODE_GROUP) . ' - ' . $group->CHR_GROUP_DESC; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td> 
                                </tr>
                                <tr>
                                    <td>Budget Type</td>
                                    <td>
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=""> -- Select Type Budget -- </option>
                                            <option value="<?php echo site_url('budget/report_budget_c/report_budget_for_gm/' . $fiscal_start . '/ALL/' . $kode_group . '/' . $kode_dept); ?>" <?php if($bgt_type == 'ALL') { echo 'selected';}?>> ALL EXPENSE </option>
                                            <?php foreach ($list_budget_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_budget_for_gm/' . $fiscal_start . '/' . trim($bgt->CHR_BUDGET_TYPE) . '/' . $kode_group . '/' . $kode_dept); ?>" <?php
                                                if ($bgt_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>                                        
                                    </td>
                                    <td></td>
                                    <td>Department</td>
                                    <td>
                                        <select name="CHR_DEPARTMENT" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;">    
                                            <option value='<?php echo site_url('budget/report_budget_c/report_budget_for_gm/' . $fiscal_start . '/' . $bgt_type. '/' . $kode_group . '/ALL'); ?>'>ALL</option>
                                            <?php foreach ($list_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/report_budget_for_gm/' . $fiscal_start . '/' . $bgt_type. '/' . $kode_group . '/' . trim($dept->CHR_KODE_DEPARTMENT)); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($dept->CHR_KODE_DEPARTMENT) . ' - ' . $dept->CHR_DEPARTMENT_DESCRIPTION; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>                                                                      
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <?php if ($data_report_gm == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                            
                        &nbsp;   
                        <div align="center">
                            <strong>Plan Ori</strong> : <span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_plan_group, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Revise</strong> : <span style="font-size: small; font-weight: bold;" class="label label-danger">Rp <?php echo number_format($tot_rev_group, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Limit</strong> : <span style="font-size: small; font-weight: bold;" class="label label-success">Rp <?php echo number_format($tot_limit_group, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Act PR</strong> : <span style="font-size: small; font-weight: bold;" class="label label-info">Rp <?php echo number_format($tot_act_group, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Act GR</strong> : <span style="font-size: small; font-weight: bold; background-color: #A692BD;" class="label label-info">Rp <?php echo number_format($tot_gr_group, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT BUDGET PER DEPT - <?php echo $bgt_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_budget_c/export_report_summary_budget_by_dept', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_DEPT" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_GROUP_DEPT" value="<?php echo $kode_group; ?>" type="hidden">
                                <input name="CHR_DEPT_DEPT" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_BUDGET_TYPE_DEPT" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit_2" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">                        
                        <div>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr style="font-weight:bold;">
                                    <td rowspan="2" align='center' style="vertical-align: middle;">No</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Department</td>
                                    <td colspan="4" align='center'>April <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>May <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>June <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>July <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>August <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>September <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>October <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>November <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>December <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>January <?php echo $fiscal_end; ?></td>
                                    <td colspan="4" align='center'>February <?php echo $fiscal_end; ?></td>
                                    <td colspan="4" align='center'>March <?php echo $fiscal_end; ?></td>
                                    <td colspan="6" align='center' style="font-weight: bold;">TOTAL</td>
                                </tr>
                                <tr style="font-weight:bold;">                                   
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstanding PR</td>
                                    <td align='center'>Limit Saldo</td>
                                    <td align='center'>Actual GR</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $session = $this->session->all_userdata();
                                $i = 1;
                                foreach ($report_per_dept as $isi) {
                                        $dept = $isi->CHR_KODE_DEPARTMENT;
                                        if ($bgt_type == 'CAPEX'){
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_dept '$fiscal_start', '$fiscal_end' , '$kode_group', '" . $isi->CHR_KODE_DEPARTMENT . "', ''");
                                        } else {
                                            if($bgt_type == 'ALL'){
                                                $new_bgt_type = '';
                                            } else {
                                                $new_bgt_type = $bgt_type;
                                            }
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_dept '$fiscal_start', '$fiscal_end' , '$new_bgt_type' , '$kode_group', '" . $isi->CHR_KODE_DEPARTMENT . "', ''");
                                        }
                                        
                                        if($GRBLN->num_rows() == 0){
                                            $GR04 = 0;
                                            $GR05 = 0;
                                            $GR06 = 0;
                                            $GR07 = 0;
                                            $GR08 = 0;
                                            $GR09 = 0;
                                            $GR10 = 0;
                                            $GR11 = 0;
                                            $GR12 = 0;
                                            $GR13 = 0;
                                            $GR14 = 0;
                                            $GR15 = 0;
                                            $tot_gr = 0;
                                        } else {
                                            $GR04 = $GRBLN->row()->GRBLN04;
                                            $GR05 = $GRBLN->row()->GRBLN05;
                                            $GR06 = $GRBLN->row()->GRBLN06;
                                            $GR07 = $GRBLN->row()->GRBLN07;
                                            $GR08 = $GRBLN->row()->GRBLN08;
                                            $GR09 = $GRBLN->row()->GRBLN09;
                                            $GR10 = $GRBLN->row()->GRBLN10;
                                            $GR11 = $GRBLN->row()->GRBLN11;
                                            $GR12 = $GRBLN->row()->GRBLN12;
                                            $GR13 = $GRBLN->row()->GRBLN13;
                                            $GR14 = $GRBLN->row()->GRBLN14;
                                            $GR15 = $GRBLN->row()->GRBLN15;
                                            $tot_gr = $GRBLN->row()->TOT_GR;
                                        }
                                        
                                        echo "<tr class='gradeX'>";
                                        echo "<td align='center'>" . $i . "</td>";
                                        echo "<td align='center'>" . $isi->CHR_KODE_DEPARTMENT . "</td>";
                                        echo "<td align='right'>" . number_format($isi->PBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR04,0,',','.') ."</td>"; 
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR05,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR06,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR07,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR08,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR09,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR10,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR11,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR12,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN13,0,',','.') . "</td>";                                        
                                        echo "<td align='right'>" . number_format($GR13,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR14,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR15,0,',','.') ."</td>";
                                        
                                        $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                                WHERE CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
                                                WHERE CHR_KODE_DEPARTMENT LIKE '$dept%' AND CHR_KODE_TYPE_BUDGET = '$bgt_type' AND CHR_TAHUN_BUDGET = '$fiscal_start' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
                                        
                                        $tot_plan = $isi->PBLN04 + $isi->PBLN05 + $isi->PBLN06 + $isi->PBLN07 + $isi->PBLN08 + $isi->PBLN09 + $isi->PBLN10
                                                    + $isi->PBLN11 + $isi->PBLN12 + $isi->PBLN13 + $isi->PBLN14 + $isi->PBLN15;
                                        $tot_limit = $isi->LBLN04 + $isi->LBLN05 + $isi->LBLN06 + $isi->LBLN07 + $isi->LBLN08 + $isi->LBLN09 + $isi->LBLN10
                                                    + $isi->LBLN11 + $isi->LBLN12 + $isi->LBLN13 + $isi->LBLN14 + $isi->LBLN15;
                                        $tot_act = $isi->OBLN04 + $isi->OBLN05 + $isi->OBLN06 + $isi->OBLN07 + $isi->OBLN08 + $isi->OBLN09 + $isi->OBLN10
                                                    + $isi->OBLN11 + $isi->OBLN12 + $isi->OBLN13 + $isi->OBLN14 + $isi->OBLN15;
                                        $lim_saldo = $tot_limit - ($tot_act + $outstd_pr->OUTSTD_PR);
                                        
                                        echo "<td align='right'>" . number_format($tot_plan,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_act,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($outstd_pr->OUTSTD_PR,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($lim_saldo,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_gr,0,',','.') . "</td>";
                                        $i++;
                                }
                                ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if($kode_dept != NULL || $kode_dept != ''){
        ?>  
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REPORT BUDGET BY SECTION - <?php echo $bgt_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>                        
                    </div>
                    <div class="grid-body">
                        <?php if ($data_report_man == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer_2" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                    </div>                    
                </div>
            </div>
        </div>
              
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT BUDGET PER SECTION - <?php echo $bgt_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_budget_c/export_report_summary_budget_by_sect', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_SECT" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_SECT" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_SECT" value="" type="hidden">
                                <input name="CHR_BUDGET_TYPE_SECT" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit_2" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">                        
                        <div>
                        <table id="example1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr style="font-weight:bold;">
                                    <td rowspan="2" align='center' style="vertical-align: middle;">No</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Department</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Section</td>
                                    <td colspan="4" align='center'>April <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>May <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>June <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>July <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>August <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>September <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>October <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>November <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>December <?php echo $fiscal_start; ?></td>
                                    <td colspan="4" align='center'>January <?php echo $fiscal_end; ?></td>
                                    <td colspan="4" align='center'>February <?php echo $fiscal_end; ?></td>
                                    <td colspan="4" align='center'>March <?php echo $fiscal_end; ?></td>
                                    <td colspan="6" align='center' style="font-weight: bold;">TOTAL</td>
                                </tr>
                                <tr style="font-weight:bold;">                                   
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstanding PR</td>
                                    <td align='center'>Limit Saldo</td>
                                    <td align='center'>Actual GR</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $session = $this->session->all_userdata();
                                $i = 1;
                                foreach ($report_per_sect as $isi) {
                                        $sect = $isi->CHR_KODE_SECTION;
                                        if ($bgt_type == 'CAPEX'){
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_sect '$fiscal_start', '$fiscal_end' , '" . $isi->CHR_KODE_DEPARTMENT . "', '" . $isi->CHR_KODE_SECTION . "', ''");
                                        } else {
                                            if($bgt_type == 'ALL'){
                                                $new_bgt_type = '';
                                            } else {
                                                $new_bgt_type = $bgt_type;
                                            }
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_sect '$fiscal_start', '$fiscal_end' , '$new_bgt_type' , '" . $isi->CHR_KODE_DEPARTMENT . "', '" . $isi->CHR_KODE_SECTION . "', ''");
                                        }
                                        
                                        if($GRBLN->num_rows() == 0){
                                            $GR04 = 0;
                                            $GR05 = 0;
                                            $GR06 = 0;
                                            $GR07 = 0;
                                            $GR08 = 0;
                                            $GR09 = 0;
                                            $GR10 = 0;
                                            $GR11 = 0;
                                            $GR12 = 0;
                                            $GR13 = 0;
                                            $GR14 = 0;
                                            $GR15 = 0;
                                            $tot_gr = 0;
                                        } else {
                                            $GR04 = $GRBLN->row()->GRBLN04;
                                            $GR05 = $GRBLN->row()->GRBLN05;
                                            $GR06 = $GRBLN->row()->GRBLN06;
                                            $GR07 = $GRBLN->row()->GRBLN07;
                                            $GR08 = $GRBLN->row()->GRBLN08;
                                            $GR09 = $GRBLN->row()->GRBLN09;
                                            $GR10 = $GRBLN->row()->GRBLN10;
                                            $GR11 = $GRBLN->row()->GRBLN11;
                                            $GR12 = $GRBLN->row()->GRBLN12;
                                            $GR13 = $GRBLN->row()->GRBLN13;
                                            $GR14 = $GRBLN->row()->GRBLN14;
                                            $GR15 = $GRBLN->row()->GRBLN15;
                                            $tot_gr = $GRBLN->row()->TOT_GR;
                                        }
                                        
                                        echo "<tr class='gradeX'>";
                                        echo "<td align='center'>" . $i . "</td>";
                                        echo "<td align='center'>" . $isi->CHR_KODE_DEPARTMENT . "</td>";
                                        echo "<td align='center'>" . $isi->CHR_KODE_SECTION . "</td>";
                                        echo "<td align='right'>" . number_format($isi->PBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR04,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR05,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR06,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR07,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR08,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR09,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR10,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR11,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR12,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR13,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR14,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR15,0,',','.') ."</td>";
                                        
                                        $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                                WHERE CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
                                                WHERE CHR_NO_BUDGET LIKE '%$sect%' AND CHR_KODE_TYPE_BUDGET = '$bgt_type' AND CHR_TAHUN_BUDGET = '$fiscal_start' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
                                                                                
                                        $tot_plan = $isi->PBLN04 + $isi->PBLN05 + $isi->PBLN06 + $isi->PBLN07 + $isi->PBLN08 + $isi->PBLN09 + $isi->PBLN10
                                                    + $isi->PBLN11 + $isi->PBLN12 + $isi->PBLN13 + $isi->PBLN14 + $isi->PBLN15;
                                        $tot_limit = $isi->LBLN04 + $isi->LBLN05 + $isi->LBLN06 + $isi->LBLN07 + $isi->LBLN08 + $isi->LBLN09 + $isi->LBLN10
                                                    + $isi->LBLN11 + $isi->LBLN12 + $isi->LBLN13 + $isi->LBLN14 + $isi->LBLN15;
                                        $tot_act = $isi->OBLN04 + $isi->OBLN05 + $isi->OBLN06 + $isi->OBLN07 + $isi->OBLN08 + $isi->OBLN09 + $isi->OBLN10
                                                    + $isi->OBLN11 + $isi->OBLN12 + $isi->OBLN13 + $isi->OBLN14 + $isi->OBLN15;
                                        
                                        $lim_saldo = $tot_limit - ($tot_act + $outstd_pr->OUTSTD_PR);
                                        
                                        echo "<td align='right'>" . number_format($tot_plan,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_act,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($outstd_pr->OUTSTD_PR,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($lim_saldo,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_gr,0,',','.') ."</td>";
                                        $i++;
                                }
                                ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <?php } ?>

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 2,
                rightColumns: 6
            }
        });
    });
    
    $(document).ready(function() {
        $('#example1').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 3,
                rightColumns: 6
            }
        });
    });
</script>