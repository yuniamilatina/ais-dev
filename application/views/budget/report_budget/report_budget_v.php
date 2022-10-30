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
                        fontSize: 30
                    },
                    toolTip: {
                        shared: true
                    },
                    axisY: {
                        title: "AMOUNT (*1Juta)",
                        gridThickness:0.2,
                        interval: 5000
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
                            dataPoints: [
<?php
$count_budget = count($data_report_man);
$tot_plan_dept = 0;
$row_plan = 1;
//BEFORE REVISE BUDGET
//foreach ($data_report_man as $bgt) {
//    if ($row_plan == $count_budget) {
//        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_PLAN / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_PLAN / 1000000000,2) . ' bio"}';
//    } else {
//        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_PLAN / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_PLAN / 1000000000,2) . ' bio"},';
//    }
//    $tot_plan_dept = $tot_plan_dept + $bgt->TOT_PLAN;
//    $row_plan++;
//}

//AFTER REVISE BUDGET
foreach ($data_report_man as $bgt) {
    $plan = $this->report_budget_m->get_new_budget_detail_sect($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT, $bgt->CHR_KODE_SECTION);
    if ($plan){
        $tot_plan = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
    }else{
        $tot_plan = 0;
    }
    //add by bugsmaker
    //$tot_plan = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
    if ($row_plan == $count_budget) {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_plan / 1000000,2) . ', indexLabel:"' . round($tot_plan / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_plan / 1000000,2) . ', indexLabel:"' . round($tot_plan / 1000000000,2) . '"},';
    }
    
    $tot_plan_dept = $tot_plan_dept + $tot_plan;
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
                                name: "REVISE",
                                legendText: "REVISE",
                                //axisYType: "secondary",
                                showInLegend: true,
                                dataPoints: [
                        
<?php
$count_budget = count($data_report_man);
$tot_rev_dept = 0;
$row_rev = 1;
foreach ($data_report_man as $bgt) {
    
    $plan = $this->report_budget_m->get_new_budget_detail_rev_sect($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT, $bgt->CHR_KODE_SECTION);
    if ($plan){
        $tot_rev = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
    }else{
        $tot_rev = 0;
    }
    //add by bugsmaker
    //$tot_rev = $plan->PBLN04 + $plan->PBLN05 + $plan->PBLN06 + $plan->PBLN07 + $plan->PBLN08 + $plan->PBLN09 + $plan->PBLN10 + $plan->PBLN11 + $plan->PBLN12 + $plan->PBLN13 + $plan->PBLN14 + $plan->PBLN15;
    if ($row_rev == $count_budget) {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_rev / 1000000,2) . ', indexLabel:"' . round($tot_rev / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_rev / 1000000,2) . ', indexLabel:"' . round($tot_rev / 1000000000,2) . '"},';
    }
    
    $tot_rev_dept = $tot_rev_dept + $tot_rev;
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
$count_budget = count($data_report_man);
$tot_limit_dept = 0;
$row_lim = 1;
//BEFORE REVISE BUDGET
foreach ($data_report_man as $bgt) {
    if ($row_lim == $count_budget) {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_LIMIT / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_LIMIT / 1000000000,2) . ' bio"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_LIMIT / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_LIMIT / 1000000000,2) . ' bio"},';
    }
    $tot_limit_dept = $tot_limit_dept + $bgt->TOT_LIMIT;
    $row_lim++;
}

//foreach ($data_report_man as $bgt) {
//    
//    $revise = $this->report_budget_m->get_new_budget_detail_rev_sect($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT, $bgt->CHR_KODE_SECTION);
//    if ($revise){
//        $tot_rev = $revise->PBLN04 + $revise->PBLN05 + $revise->PBLN06 + $revise->PBLN07 + $revise->PBLN08 + $revise->PBLN09 + $revise->PBLN10 + $revise->PBLN11 + $revise->PBLN12 + $revise->PBLN01 + $revise->PBLN02 + $revise->PBLN03;
//    }else{
//        $tot_rev = 0;
//    }
//    //add by bugsmaker
//    //$tot_rev = $revise->PBLN04 + $revise->PBLN05 + $revise->PBLN06 + $revise->PBLN07 + $revise->PBLN08 + $revise->PBLN09 + $revise->PBLN10 + $revise->PBLN11 + $revise->PBLN12 + $revise->PBLN13 + $revise->PBLN14 + $revise->PBLN15;
//    if ($row_lim == $count_budget) {
//        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round(($tot_rev*(70/100)) / 1000000,2) . ', indexLabel:"' . round(($tot_rev*(70/100)) / 1000000000,2) . '"}';
//    } else {
//        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round(($tot_rev*(70/100)) / 1000000,2) . ', indexLabel:"' . round(($tot_rev*(70/100)) / 1000000000,2) . '"},';
//    }
//    
//    $tot_limit_dept = $tot_limit_dept + ($tot_rev*(70/100));
//    $row_lim++;
//}
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
$count_budget = count($data_report_man);
$tot_act_dept = 0;
$row_act = 1;
//BEFORE REVISE BUDGET
//foreach ($data_report_man as $bgt) {
//    if ($row_act == $count_budget) {        
//        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_ACTUAL / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_ACTUAL / 1000000000,2) . ' bio"}';
//    } else {
//        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($bgt->TOT_ACTUAL / 1000000,2) . ', indexLabel:"' . round($bgt->TOT_ACTUAL / 1000000000,2) . ' bio"},';
//    }
//    $tot_act_dept = $tot_act_dept + $bgt->TOT_ACTUAL;
//    $row_act++;
//}

//AFTER REVISE BUDGET
foreach ($data_report_man as $bgt) {
    
    $pr = $this->report_budget_m->get_new_actual_real_sect($fiscal_start, $fiscal_start, $fiscal_end, $new_bgt_type, $bgt->CHR_KODE_DEPARTMENT, $bgt->CHR_KODE_SECTION);
    if ($pr){
        $tot_pr = $pr->OPRBLN04 + $pr->OPRBLN05 + $pr->OPRBLN06 + $pr->OPRBLN07 + $pr->OPRBLN08 + $pr->OPRBLN09 + $pr->OPRBLN10 + $pr->OPRBLN11 + $pr->OPRBLN12 + $pr->OPRBLN13 + $pr->OPRBLN14 + $pr->OPRBLN15;
    } else  {
        $tot_pr = 0;
    }
    //add by bugsmaker
    //$tot_pr = $pr->OPRBLN04 + $pr->OPRBLN05 + $pr->OPRBLN06 + $pr->OPRBLN07 + $pr->OPRBLN08 + $pr->OPRBLN09 + $pr->OPRBLN10 + $pr->OPRBLN11 + $pr->OPRBLN12 + $pr->OPRBLN13 + $pr->OPRBLN14 + $pr->OPRBLN15;
    if ($row_act == $count_budget) {        
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_pr / 1000000,2) . ', indexLabel:"' . round($tot_pr / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_pr / 1000000,2) . ', indexLabel:"' . round($tot_pr / 1000000000,2) . '"},';
    }
    
    $tot_act_dept = $tot_act_dept + $tot_pr;
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
$tot_gr_dept = 0;
$row_gr = 1;
foreach ($data_report_man as $bgt) {    
    if ($bgt_type == 'CAPEX'){
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_capex_chart_sect '$fiscal_start', '$fiscal_end' , '".$bgt->CHR_KODE_DEPARTMENT."', '".$bgt->CHR_KODE_SECTION."', ''");
    } else if ($bgt_type == 'CONSU'){
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_consumable_chart_sect '$fiscal_start', '$fiscal_end' , '$bgt_type' , '".$bgt->CHR_KODE_DEPARTMENT."', '".$bgt->CHR_KODE_SECTION."', ''");
    } else {
        $data_gr = $bgt_aii->query("EXEC zsp_get_gr_expense_chart_sect '$fiscal_start', '$fiscal_end' , '$bgt_type' , '".$bgt->CHR_KODE_DEPARTMENT."', '".$bgt->CHR_KODE_SECTION."', ''");
    }
    
    if($data_gr->num_rows() == 0){
        $tot_gr = 0;
    } else {
        $tot_gr = $data_gr->row()->TOT_GR;
    }
    
    
    if ($row_gr == $count_budget) {        
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_gr / 1000000,2) . ', indexLabel:"' . round($tot_gr / 1000000000,2) . '"}';
    } else {
        echo '{label: "' . $bgt->CHR_KODE_SECTION . '", y:' . round($tot_gr / 1000000,2) . ', indexLabel:"' . round($tot_gr / 1000000000,2) . '"},';
    }
    $tot_gr_dept = $tot_gr_dept + $tot_gr;
    $row_gr++;
}
?>
                        ]
                            }

                        ],
                        legend: {
                            cursor: "pointer",
                            itemclick: function(e) {
                                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                    e.dataSeries.visible = false;
                                }
                                else {
                                    e.dataSeries.visible = true;
                                }
                                chart.render();
                            }
                        }
                    });

            chart.render();
        }
                </script>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REPORT BUDGET CHART - <?php echo $bgt_type; ?></strong></span>
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
                                                <option value="<?PHP echo site_url('budget/report_budget_c/index/' . $data->CHR_FISCAL_YEAR_START . '/' . $kode_dept . '/' . $bgt_type); ?>" <?php
                                                if ($fiscal_start == $data->CHR_FISCAL_YEAR_START) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%">Department</td>
                                    <td width="20%">
                                        <?php if($role == '1' || $role == '2' || $role == '13' || $npk == '0483' || $npk == '0483a' || $npk == '7520' || $npk == '1582' || $npk == '3394' || $npk == '9692' || $npk == '1392' || $npk == '1733' || $npk == '5913' ){?>
                                        <select name="CHR_DEPARTMENT" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                        <?php } else { ?>
                                        <select name="CHR_DEPARTMENT" class="form-control" id="dept_name" onchange="document.location.href = this.options[this.selectedIndex].value;" disabled>    
                                        <?php } ?>
                                            <option value=''></option>
                                            <?php foreach ($list_dept as $dept) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/index/' . $fiscal_start . '/' . $bgt_type. '/' . trim($dept->CHR_KODE_DEPARTMENT) . '/' . $kode_sect); ?>" <?php
                                                if ($kode_dept == trim($dept->CHR_KODE_DEPARTMENT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo trim($dept->CHR_KODE_DEPARTMENT) . ' - ' . $dept->CHR_DEPARTMENT_DESCRIPTION; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td> 
                                </tr>
                                <tr>
                                    <td width="10%">Budget Type</td>
                                    <td width="20%">
                                        <select name="CHR_BUDGET_TYPE" class="form-control" id="budget_type" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value=''> -- Select Type Budget -- </option>
                                            <?php foreach ($list_budget_type as $bgt) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/index/' . $fiscal_start . '/' . trim($bgt->CHR_BUDGET_TYPE) . '/' . $kode_dept . '/' . $kode_sect); ?>" <?php
                                                if ($bgt_type == trim($bgt->CHR_BUDGET_TYPE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                                    <?php } ?>
                                        </select>                                        
                                    </td>
                                    <td width="20%"></td>
                                    <td width="10%">Section</td>
                                    <td width="20%">
                                        <select name="CHR_SECTION" class="form-control" id="section" onchange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value='<?php echo site_url('budget/report_budget_c/index/' . $fiscal_start . '/' . $bgt_type . '/' . $kode_dept . '/ALL'); ?>'>ALL</option>
                                            <?php foreach ($list_sect as $sect) { ?>
                                                <option value="<?php echo site_url('budget/report_budget_c/index/' . $fiscal_start . '/' . $bgt_type . '/' . $kode_dept . '/' . trim($sect->CHR_KODE_SECTION)); ?>" <?php
                                                if ($kode_sect == trim($sect->CHR_KODE_SECTION)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $sect->CHR_KODE_SECTION; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="20%"></td>
                                </tr>                                                     
                            </table>
                        </div>
                        <div>&nbsp;</div>
                        <?php if ($data_report_man == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                            
                        &nbsp;   
                        <div align="center">
                            <strong>Plan Ori</strong> : <span style="font-size: small; font-weight: bold;" class="label label-primary">Rp <?php echo number_format($tot_plan_dept, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Revise</strong> : <span style="font-size: small; font-weight: bold;" class="label label-danger">Rp <?php echo number_format($tot_rev_dept, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Limit</strong> : <span style="font-size: small; font-weight: bold;" class="label label-success">Rp <?php echo number_format($tot_limit_dept, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Act PR</strong> : <span style="font-size: small; font-weight: bold;" class="label label-info">Rp <?php echo number_format($tot_act_dept, 0, ',', '.'); ?></span> &nbsp;&nbsp;
                            <strong>Act GR</strong> : <span style="font-size: small; font-weight: bold; background-color: #A692BD;" class="label label-info">Rp <?php echo number_format($tot_gr_dept, 0, ',', '.'); ?></span> &nbsp;&nbsp;
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
                        <span class="grid-title"><strong>REPORT BUDGET PER SECTION - <?php echo $bgt_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_budget_c/export_report_summary_budget_by_sect', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_SECT" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_SECT" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_SECT" value="<?php echo $kode_sect; ?>" type="hidden">
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
                                    <td colspan="5" align='center'>April <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>May <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>June <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>July <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>August <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>September <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>October <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>November <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>December <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>January <?php echo $fiscal_end; ?></td>
                                    <td colspan="5" align='center'>February <?php echo $fiscal_end; ?></td>
                                    <td colspan="5" align='center'>March <?php echo $fiscal_end; ?></td>
                                    <td colspan="6" align='center' style="font-weight: bold;">TOTAL</td>
                                </tr>
                                <tr style="font-weight:bold;">                                   
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Limit Saldo</td>
                                    <td align='center'>Actual GR</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bgt_aii = $this->load->database("bgt_aii", TRUE);
                                $session = $this->session->all_userdata();
                                $i = 1;
                                foreach ($report_per_sect as $isi) {
                                        $sect = $isi->CHR_KODE_SECTION;
                                        if($sect == 'MIS-BIN'){
                                            $sect = 'MIS-BAI';
                                        }
                                        if ($bgt_type == 'CAPEX'){
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_sect '$fiscal_start', '$fiscal_end' , '" . $isi->CHR_KODE_DEPARTMENT . "', '" . $sect . "', ''");                                            
                                        } else {
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_sect '$fiscal_start', '$fiscal_end' , '$bgt_type' , '" . $isi->CHR_KODE_DEPARTMENT . "', '" . $sect . "', ''");
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

                                        $outstd_pr = $this->report_budget_m->get_pr_outstanding($fiscal_start, $fiscal_end, $bgt_type, $isi->CHR_KODE_DEPARTMENT, trim($sect));
                                        if($outstd_pr->num_rows() == 0){
                                            $PR04 = 0;
                                            $PR05 = 0;
                                            $PR06 = 0;
                                            $PR07 = 0;
                                            $PR08 = 0;
                                            $PR09 = 0;
                                            $PR10 = 0;
                                            $PR11 = 0;
                                            $PR12 = 0;
                                            $PR13 = 0;
                                            $PR14 = 0;
                                            $PR15 = 0;
                                            $tot_pr_outstd = 0;
                                        } else {
                                            $PR04 = $outstd_pr->row()->PR04;
                                            $PR05 = $outstd_pr->row()->PR05;
                                            $PR06 = $outstd_pr->row()->PR06;
                                            $PR07 = $outstd_pr->row()->PR07;
                                            $PR08 = $outstd_pr->row()->PR08;
                                            $PR09 = $outstd_pr->row()->PR09;
                                            $PR10 = $outstd_pr->row()->PR10;
                                            $PR11 = $outstd_pr->row()->PR11;
                                            $PR12 = $outstd_pr->row()->PR12;
                                            $PR13 = $outstd_pr->row()->PR13;
                                            $PR14 = $outstd_pr->row()->PR14;
                                            $PR15 = $outstd_pr->row()->PR15;
                                            $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
                                        }


                                        echo "<tr class='gradeX'>";
                                        echo "<td align='center'>" . $i . "</td>";
                                        echo "<td align='center'>" . $isi->CHR_KODE_DEPARTMENT . "</td>";
                                        echo "<td align='center'>" . $isi->CHR_KODE_SECTION . "</td>";
                                        echo "<td align='right'>" . number_format($isi->PBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR04,0,',','.') ."</td>"; 
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR05,0,',','.') ."</td>";  
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR06,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR07,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR08,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR09,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR10,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR11,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR12,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR13,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR14,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR15,0,',','.') ."</td>";
                                        
                                        // if ($bgt_type == 'CAPEX'){
                                        //     $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                        //         WHERE CHR_KODE_TRANSAKSI IN (SELECT A.CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER AS A
                                        //         LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        //         WHERE B.CHR_NO_BUDGET LIKE '%$sect%' AND A.CHR_KODE_TYPE_BUDGET = '$bgt_type' AND A.CHR_TAHUN_BUDGET = '$fiscal_start' AND A.CHR_FLG_APPROVE_BOD = '0' AND A.CHR_FLG_DELETE = '0')")->row();
                                        // } else {
                                        //     $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                        //         WHERE CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
                                        //         WHERE CHR_NO_BUDGET LIKE '%$sect%' AND CHR_KODE_TYPE_BUDGET = '$bgt_type' AND CHR_TAHUN_BUDGET = '$fiscal_start' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
                                        // }
                                        
                                        $tot_plan = $isi->PBLN04 + $isi->PBLN05 + $isi->PBLN06 + $isi->PBLN07 + $isi->PBLN08 + $isi->PBLN09 + $isi->PBLN10
                                                    + $isi->PBLN11 + $isi->PBLN12 + $isi->PBLN13 + $isi->PBLN14 + $isi->PBLN15;
                                        $tot_limit = $isi->LBLN04 + $isi->LBLN05 + $isi->LBLN06 + $isi->LBLN07 + $isi->LBLN08 + $isi->LBLN09 + $isi->LBLN10
                                                    + $isi->LBLN11 + $isi->LBLN12 + $isi->LBLN13 + $isi->LBLN14 + $isi->LBLN15;
                                        $tot_act = $isi->OBLN04 + $isi->OBLN05 + $isi->OBLN06 + $isi->OBLN07 + $isi->OBLN08 + $isi->OBLN09 + $isi->OBLN10
                                                    + $isi->OBLN11 + $isi->OBLN12 + $isi->OBLN13 + $isi->OBLN14 + $isi->OBLN15;
                                        
                                        // $lim_saldo = $tot_limit - ($tot_act + $outstd_pr->OUTSTD_PR);
                                        $lim_saldo = $tot_limit - ($tot_act + $tot_pr_outstd);
                                                
                                        echo "<td align='right'>" . number_format($tot_plan,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_act,0,',','.') . "</td>";
                                        // echo "<td align='right'>" . number_format($outstd_pr->OUTSTD_PR,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_pr_outstd,0,',','.') . "</td>";
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
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT DETAIL BUDGET - <?php echo $bgt_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_budget_c/export_report_summary_budget', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_EXP" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_EXP" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_EXP" value="<?php echo $kode_sect; ?>" type="hidden">
                                <input name="CHR_BUDGET_TYPE_EXP" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">                        
                        <div>
                        <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr style="font-weight:bold;">
                                    <td rowspan="2" align='center' style="vertical-align: middle;">No</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Budget No</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Description</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Status</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">CIP</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Department</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Category</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Project</td>
                                    <td colspan="5" align='center'>April <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>May <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>June <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>July <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>August <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>September <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>October <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>November <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>December <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>January <?php echo $fiscal_end; ?></td>
                                    <td colspan="5" align='center'>February <?php echo $fiscal_end; ?></td>
                                    <td colspan="5" align='center'>March <?php echo $fiscal_end; ?></td>
                                    <td colspan="6" align='center' style="font-weight: bold;">TOTAL</td>
                                </tr>
                                <tr style="font-weight:bold;">                                   
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Limit Saldo</td>
                                    <td align='center'>Actual GR</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 1;
                                foreach ($list_data as $isi) {
                                        if ($bgt_type == 'CAPEX'){
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_no_budget '$fiscal_start', '$fiscal_end' , '" . $isi->CHR_NO_BUDGET . "', ''");
                                        } else {
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_no_budget '$fiscal_start', '$fiscal_end' , '$bgt_type' , '" . $isi->CHR_NO_BUDGET . "', ''");
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

                                        $outstd_pr = $this->report_budget_m->get_pr_outstanding_by_no_budget($fiscal_start, $fiscal_end, $bgt_type, $isi->CHR_KODE_DEPARTMENT, trim($sect), trim($isi->CHR_NO_BUDGET));
                                        if($outstd_pr->num_rows() == 0){
                                            $PR04 = 0;
                                            $PR05 = 0;
                                            $PR06 = 0;
                                            $PR07 = 0;
                                            $PR08 = 0;
                                            $PR09 = 0;
                                            $PR10 = 0;
                                            $PR11 = 0;
                                            $PR12 = 0;
                                            $PR13 = 0;
                                            $PR14 = 0;
                                            $PR15 = 0;
                                            $tot_pr_outstd = 0;
                                        } else {
                                            $PR04 = $outstd_pr->row()->PR04;
                                            $PR05 = $outstd_pr->row()->PR05;
                                            $PR06 = $outstd_pr->row()->PR06;
                                            $PR07 = $outstd_pr->row()->PR07;
                                            $PR08 = $outstd_pr->row()->PR08;
                                            $PR09 = $outstd_pr->row()->PR09;
                                            $PR10 = $outstd_pr->row()->PR10;
                                            $PR11 = $outstd_pr->row()->PR11;
                                            $PR12 = $outstd_pr->row()->PR12;
                                            $PR13 = $outstd_pr->row()->PR13;
                                            $PR14 = $outstd_pr->row()->PR14;
                                            $PR15 = $outstd_pr->row()->PR15;
                                            $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
                                        }
                                        
                                        echo "<tr class='gradeX'>";
                                        echo "<td align='center'>" . $x . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_NO_BUDGET . "</td>";
                                        echo "<td align='left'>" . substr($isi->CHR_DESC_BUDGET,0,25) . "</td>";
                                        
                                        if($isi->CHR_FLG_CANCEL == '1'){
                                            echo "<td align='center' style='background-color:black;color:white;'>CANCEL</td>";
                                        } else {
                                            if($isi->CHR_FLG_APPROVAL_PROCESS == '1'){
                                                echo "<td align='center'>WAIT</td>";
                                            } else {
                                                if($bgt_type == 'CAPEX'){
                                                    if($isi->CHR_FLG_USED == '1' && $isi->CHR_FLG_CIP == '0'){
                                                        echo "<td align='center' style='background-color:grey;color:white;'>CLOSED</td>";
                                                    } else {
                                                        echo "<td align='center' style='background-color:blue;color:white;'>OPEN</td>";
                                                    }
                                                } else {
                                                    echo "<td align='center' style='background-color:blue;color:white;'>OPEN</td>";
                                                }                                                
                                            }                                            
                                        }

                                        if($bgt_type == 'CAPEX'){
                                            if($isi->CHR_FLG_CIP == '1'){
                                                echo "<td align='center'>Yes</td>";
                                            } else {
                                                echo "<td align='center'>-</td>";
                                            }
                                        } else {
                                            echo "<td align='center'>-</td>";
                                        }                                        
                                                                                
                                        echo "<td align='center'>" . $isi->CHR_KODE_DEPARTMENT . "</td>";
                                        echo "<td align='right'>" . $isi->CHR_KODE_SUBCATEGORY_BUDGET . "</td>";
                                        echo "<td align='right'>" . $isi->CHR_DESC_PROJECT . "</td>";
                                        echo "<td align='right'>" . number_format($isi->PBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR04,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR05,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR06,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR07,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR08,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR09,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR10,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR11,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR12,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR13,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR14,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR15,0,',','.') ."</td>";
                                        
                                        // if($bgt_type != 'CAPEX'){
                                        // $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                        //         WHERE CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
                                        //         WHERE CHR_NO_BUDGET = '$isi->CHR_NO_BUDGET' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
                                        // }else{
                                        //     $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                        //         WHERE CHR_KODE_TRANSAKSI IN (SELECT A.CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER AS A
                                        //         LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        //         WHERE B.CHR_NO_BUDGET = '$isi->CHR_NO_BUDGET' AND A.CHR_FLG_APPROVE_BOD = '0' AND A.CHR_FLG_DELETE = '0')")->row();
                                        // }
                                        
                                        $tot_plan = $isi->PBLN04 + $isi->PBLN05 + $isi->PBLN06 + $isi->PBLN07 + $isi->PBLN08 + $isi->PBLN09 + $isi->PBLN10
                                                    + $isi->PBLN11 + $isi->PBLN12 + $isi->PBLN13 + $isi->PBLN14 + $isi->PBLN15;
                                        $tot_limit = $isi->LBLN04 + $isi->LBLN05 + $isi->LBLN06 + $isi->LBLN07 + $isi->LBLN08 + $isi->LBLN09 + $isi->LBLN10
                                                    + $isi->LBLN11 + $isi->LBLN12 + $isi->LBLN13 + $isi->LBLN14 + $isi->LBLN15;
                                        $tot_act = $isi->OBLN04 + $isi->OBLN05 + $isi->OBLN06 + $isi->OBLN07 + $isi->OBLN08 + $isi->OBLN09 + $isi->OBLN10
                                                    + $isi->OBLN11 + $isi->OBLN12 + $isi->OBLN13 + $isi->OBLN14 + $isi->OBLN15;
                                        if($GRBLN->num_rows() == 0){
                                            $tot_gr = 0;
                                        } else {
                                            $tot_gr= $GRBLN->row()->TOT_GR;
                                        }
                                        
                                        // $lim_saldo = $tot_limit - ($tot_act + $outstd_pr->OUTSTD_PR);
                                        $lim_saldo = $tot_limit - ($tot_act + $tot_pr_outstd);
                                                
                                        echo "<td align='right'>" . number_format($tot_plan,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_act,0,',','.') . "</td>";
                                        // echo "<td align='right'>" . number_format($outstd_pr->OUTSTD_PR,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_pr_outstd,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($lim_saldo,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_gr,0,',','.') . "</td>";
                                        $x++;
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
            if($bgt_type != 'CAPEX'){
                $date_now = date('Ymd');
                $smt2 = $fiscal_start . '1001';
                if ($date_now >= $smt2){
                //if($role == '1' || $role == '13') { 
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-book"></i>
                        <span class="grid-title"><strong>REPORT DETAIL BUDGET - <?php echo $bgt_type; ?> (NO BUDGET SMT 1)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('budget/report_budget_c/export_report_summary_budget_smt1', 'class="form-horizontal"'); ?>
                                <input name="CHR_FISCAL_EXP" value="<?php echo $fiscal_start; ?>" type="hidden">
                                <input name="CHR_DEPT_EXP" value="<?php echo $kode_dept; ?>" type="hidden">
                                <input name="CHR_SECT_EXP" value="<?php echo $kode_sect; ?>" type="hidden">
                                <input name="CHR_BUDGET_TYPE_EXP" value="<?php echo $bgt_type; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">                        
                        <div>
                        <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style=" font-size: 11px;">
                            <thead>
                                <tr style="font-weight:bold;">
                                    <td rowspan="2" align='center' style="vertical-align: middle;">No</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Budget No</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Description</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Department</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Category</td>
                                    <td rowspan="2" align='center' style="vertical-align: middle;">Project</td>
                                    <td colspan="5" align='center'>April <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>May <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>June <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>July <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>August <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>September <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>October <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>November <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>December <?php echo $fiscal_start; ?></td>
                                    <td colspan="5" align='center'>January <?php echo $fiscal_end; ?></td>
                                    <td colspan="5" align='center'>February <?php echo $fiscal_end; ?></td>
                                    <td colspan="5" align='center'>March <?php echo $fiscal_end; ?></td>
                                    <td colspan="6" align='center' style="font-weight: bold;">TOTAL</td>
                                </tr>
                                <tr style="font-weight:bold;">                                   
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Actual GR</td>
                                    <td align='center'>Plan</td>
                                    <td align='center'>Limit</td>
                                    <td align='center'>Actual PR</td>
                                    <td align='center'>Outstd PR</td>
                                    <td align='center'>Limit Saldo</td>
                                    <td align='center'>Actual GR</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $y = 1;
                                foreach ($list_data_smt1 as $isi) {
                                        if ($bgt_type == 'CAPEX'){
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_no_budget '$fiscal_start', '$fiscal_end' , '" . $isi->CHR_NO_BUDGET . "', ''");
                                        } else {
                                            $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_no_budget '$fiscal_start', '$fiscal_end' , '$bgt_type' , '" . $isi->CHR_NO_BUDGET . "', ''");
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

                                        $outstd_pr = $this->report_budget_m->get_pr_outstanding_by_no_budget($fiscal_start, $fiscal_end, $bgt_type, $isi->CHR_KODE_DEPARTMENT, trim($sect), trim($isi->CHR_NO_BUDGET));
                                        if($outstd_pr->num_rows() == 0){
                                            $PR04 = 0;
                                            $PR05 = 0;
                                            $PR06 = 0;
                                            $PR07 = 0;
                                            $PR08 = 0;
                                            $PR09 = 0;
                                            $PR10 = 0;
                                            $PR11 = 0;
                                            $PR12 = 0;
                                            $PR13 = 0;
                                            $PR14 = 0;
                                            $PR15 = 0;
                                            $tot_pr_outstd = 0;
                                        } else {
                                            $PR04 = $outstd_pr->row()->PR04;
                                            $PR05 = $outstd_pr->row()->PR05;
                                            $PR06 = $outstd_pr->row()->PR06;
                                            $PR07 = $outstd_pr->row()->PR07;
                                            $PR08 = $outstd_pr->row()->PR08;
                                            $PR09 = $outstd_pr->row()->PR09;
                                            $PR10 = $outstd_pr->row()->PR10;
                                            $PR11 = $outstd_pr->row()->PR11;
                                            $PR12 = $outstd_pr->row()->PR12;
                                            $PR13 = $outstd_pr->row()->PR13;
                                            $PR14 = $outstd_pr->row()->PR14;
                                            $PR15 = $outstd_pr->row()->PR15;
                                            $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
                                        }

                                        
                                        echo "<tr class='gradeX'>";
                                        echo "<td align='center'>" . $y . "</td>";
                                        echo "<td align='left'>" . $isi->CHR_NO_BUDGET . "</td>";
                                        echo "<td align='left'>" . substr($isi->CHR_DESC_BUDGET,0,25) . "</td>";
                                        echo "<td align='center'>" . $isi->CHR_KODE_DEPARTMENT . "</td>";
                                        echo "<td align='right'>" . $isi->CHR_KODE_SUBCATEGORY_BUDGET . "</td>";
                                        echo "<td align='right'>" . $isi->CHR_DESC_PROJECT . "</td>";
                                        echo "<td align='right'>" . number_format($isi->PBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR04,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR04,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR05,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR05,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR06,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR06,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR07,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR07,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR08,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR08,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR09,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR09,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR10,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR10,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR11,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR11,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR12,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR12,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR13,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR13,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR14,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR14,0,',','.') ."</td>";
                                        
                                        echo "<td align='right'>" . number_format($isi->PBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->LBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($isi->OBLN15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($PR15,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($GR15,0,',','.') ."</td>";
                                        
                                        // if($bgt_type != 'CAPEX'){
                                        // $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                        //         WHERE CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
                                        //         WHERE CHR_NO_BUDGET = '$isi->CHR_NO_BUDGET' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
                                        // }else{
                                        //     $outstd_pr = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
                                        //         WHERE CHR_KODE_TRANSAKSI IN (SELECT A.CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER AS A
                                        //         LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        //         WHERE B.CHR_NO_BUDGET = '$isi->CHR_NO_BUDGET' AND A.CHR_FLG_APPROVE_BOD = '0' AND A.CHR_FLG_DELETE = '0')")->row();
                                        // }
                                        
                                        $tot_plan = $isi->PBLN04 + $isi->PBLN05 + $isi->PBLN06 + $isi->PBLN07 + $isi->PBLN08 + $isi->PBLN09 + $isi->PBLN10
                                                    + $isi->PBLN11 + $isi->PBLN12 + $isi->PBLN13 + $isi->PBLN14 + $isi->PBLN15;
                                        $tot_limit = $isi->LBLN04 + $isi->LBLN05 + $isi->LBLN06 + $isi->LBLN07 + $isi->LBLN08 + $isi->LBLN09 + $isi->LBLN10
                                                    + $isi->LBLN11 + $isi->LBLN12 + $isi->LBLN13 + $isi->LBLN14 + $isi->LBLN15;
                                        $tot_act = $isi->OBLN04 + $isi->OBLN05 + $isi->OBLN06 + $isi->OBLN07 + $isi->OBLN08 + $isi->OBLN09 + $isi->OBLN10
                                                    + $isi->OBLN11 + $isi->OBLN12 + $isi->OBLN13 + $isi->OBLN14 + $isi->OBLN15;
                                        if($GRBLN->num_rows() == 0){
                                            $tot_gr = 0;
                                        } else {
                                            $tot_gr= $GRBLN->row()->TOT_GR;
                                        }
                                        
                                        // $lim_saldo = $tot_limit - ($tot_act + $outstd_pr->OUTSTD_PR);
                                        $lim_saldo = $tot_limit - ($tot_act + $tot_pr_outstd);
                                                
                                        echo "<td align='right'>" . number_format($tot_plan,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_limit,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_act,0,',','.') . "</td>";
                                        // echo "<td align='right'>" . number_format($outstd_pr->OUTSTD_PR,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_pr_outstd,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($lim_saldo,0,',','.') . "</td>";
                                        echo "<td align='right'>" . number_format($tot_gr,0,',','.') . "</td>";
                                        $y++;
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
            //}
            }
        }
        ?>
        
        <!-- DETAIL BUDGET PER DEPT -->        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL BUDGET <?php echo $bgt_type; ?> - DEPT <?php echo $kode_dept; ?> FY <?php echo $fiscal_start; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>                            
                        </div>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo site_url("budget/report_budget_c/export_report_task_force_budget/"); ?>" class="btn btn-primary"  id="btn-download-excel" style="color:white;"><i class="fa fa-download"></i>&nbsp; Task Force Report</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='150px' src="<?php echo site_url("budget/report_budget_c/view_detail_budget_dept/" . $fiscal_start . "/" . $bgt_type . "/" . $kode_dept . "/" . $kode_sect); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- DETAIL BUDGET PER DEPT -->
        <?php 
            if($role == '1' || $role == '2' || $role == '13' || $npk == '0799' || $npk == '0483' || $npk == '0483a' || $npk == '5252' || $npk == '0427' || $npk == '5913'){
        ?>
         <!-- DETAIL BUDGET PER GROUP -->        
         <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL BUDGET <?php echo $bgt_type; ?> - GROUP FY <?php echo $fiscal_start; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='150px' src="<?php echo site_url("budget/report_budget_c/view_detail_budget_gm/" . $fiscal_start . "/" . $bgt_type . "/" . $kode_dept . "/" . $kode_sect); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- DETAIL BUDGET PLANT -->        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL USAGE BUDGET - PLANT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='250px' src="<?php echo site_url("budget/purchase_request_c/view_detail_budget_plant/" . $fiscal_start . "/" . $bgt_type); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- DETAIL BUDGET PLANT -->
        <!-- DETAIL BUDGET PER GROUP -->
        <?php if($bgt_type == 'CAPEX' || $bgt_type == 'REPMA' || $bgt_type == 'TOOEQ') { ?>
        <!-- DETAIL BUDGET ADDITIONAL -->        
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL BUDGET <?php echo $bgt_type; ?> - LIMIT BUDGET OF END FY <?php echo $fiscal_start; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='150px' src="<?php echo site_url("budget/purchase_request_c/view_detail_limit_budget/" . $fiscal_start . "/" . $bgt_type); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- DETAIL BUDGET ADDITIONAL -->
        <?php 
            }
        } 
        ?>

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });

    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 4,
                rightColumns: 6
            }
        });
    });
    
    $(document).ready(function() {
        $('#example1').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 3,
                rightColumns: 6
            }
        });
    });
    
    $(document).ready(function() {
        $('#example2').DataTable({
            scrollX: true,
            lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 3,
                rightColumns: 6
            }
        });
    });
</script>