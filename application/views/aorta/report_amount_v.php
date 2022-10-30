<?php
$aortadb = $this->load->database("aorta", TRUE);
$this->load->model('aorta/master_data_m');
?>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<?php
?>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT OVERTIME BY AMOUNT</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">            
                <script type="text/javascript">
                    window.onload = function() {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme1",
                                    animationEnabled: true,
                                    title: {
                                        text: "",
                                        fontSize: 30
                                    },
                                    toolTip: {
                                        shared: true
                                    },
                                    axisY: {
                                        title: "Amount",
                                        interval: 20000000
                                    },
                                    axisY2: {
                                        title: "Amount",
                                        interval: 20000000
                                    },
                                    data: [
                                        {
                                            type: "column",
                                            name: "PLAN (Rp)",
                                            legendText: "PLAN",
                                            showInLegend: true,
                                            dataPoints: [
<?php
$row_plan = 1;
foreach ($data_summary_plan as $isi) {
    if ($row_plan != 2) {
        echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '},';
        $row_plan++;
    } else {
        echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '}';
    }
}
?>
                                            ]
                                        },
                                        {
                                            type: "column",
                                            name: "REALISASI (Rp)",
                                            legendText: "REALISASI",
                                            //axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: [
<?php
$row_act = 1;
foreach ($data_summary_real as $isi) {
    if ($row_act != 2) {
        echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '},';
        $row_act++;
    } else {
        echo '{label: "' . $isi->SECT . '", y:' . $isi->AMOUNT . '}';
    }
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
                        <span class="grid-title"><strong>OVERTIME COLUMN CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                             <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Overtime Report by</td>
                                    <td width="60%">
                                        <select class="ddl" id="report_type" onChange="document.location.href = #">
                                            <option value="amount"> Amount </option>
                                            <option value="hour"> Hour </option>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:right;' colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                             </table>
                        </div>

                        <?php if ($data_summary_plan == 0) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">REPORT OVERTIME BY<strong> AMOUNT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">

                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="60%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) {  $y = $x * 28 ?>
                                                <option value="<?PHP echo site_url('aorta/report_amount_c/index/' . date("Ym", strtotime("+$y day")) . "/$id_prod/$id_section"); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:right;' colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="60%">
                                        <?php if ($role == 5) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/report_amount_c/index/" . $selected_date . '/' . $row->INT_ID_DEPT . "/$id_section"); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Section</td>
                                    <td width="60%">


                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_amount_c/index/' . $selected_date . "/$id_prod/$row->KODE"); ?>" 
                                                <?php
                                                if (trim($id_section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->NAMA_SECTION); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="60%"></td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" >
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">Section</th>
                                        <th rowspan="2" style="vertical-align: middle;">Criteria</th>
                                        <th rowspan="2" style="vertical-align: middle;"></th>
                                        <th rowspan="2" style="vertical-align: middle;">Total</th>
                                        <th colspan="31" style="vertical-align: middle;text-align:center;">Date</th>
                                    </tr>
                                    <tr>
                                        <?php for ($index = 1; $index < 32; $index++) { ?>
                                            <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:50px;" ><?php echo $index ?></th>
                                        <?php } ?>
                                    </tr>

                                </thead>
                                <tbody>

                                    <?php foreach ($chose_work_centers as $value) { ?>
                                        <!-- MAN POWER -->
                                        <tr>
                                            <td rowspan="11" style="text-align: center; vertical-align: middle; background-color: #F3F4F5">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="1" style="text-align: right; vertical-align: middle; background-color: #F3F4F5">
                                                Man Power (MP)
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                ---
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $planning_hour = $aortadb->query("EXEC zsp_get_plan_hour '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->ROW();
                                            ?>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_01 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_02 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_03 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_04 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_05 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_06 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_07 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_08 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_09 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_10 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_11 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_12 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_13 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_14 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_15 / 60) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_16 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_17 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_18 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_19 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_20 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_21 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_22 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_23 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_24 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_25 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_26 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_27 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_28 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_29 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_30 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_31 / 60) ?>
                                            </td>
                                        </tr>
                                        <!-- OT PLAN - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                OT Plan
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                Hour
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $planning_hour = $aortadb->query("EXEC zsp_get_plan_hour '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->ROW();
                                            ?>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_01 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_02 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_03 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_04 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_05 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_06 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_07 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_08 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_09 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_10 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_11 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_12 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_13 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_14 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_15 / 60) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_16 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_17 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_18 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_19 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_20 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_21 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_22 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_23 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_24 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_25 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_26 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_27 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_28 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_29 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_30 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_hour->HOUR_31 / 60) ?>
                                            </td>
                                        </tr>
                                        <!-- OT PLAN - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Plan
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $planning_amount = $aortadb->query("EXEC zsp_get_plan_amount '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->ROW();
                                            ?>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_01) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_02) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_03) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_04) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_05) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_06) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_07) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_08) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_09) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_10) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_11) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_12) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_13) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_14) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_15) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_16) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_17) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_18) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_19) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_20) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_21) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_22) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_23) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_24) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_25) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_26) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_27) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_28) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_29) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_30) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($planning_amount->AMO_31) ?>
                                            </td>
                                        </tr>
                                        <!-- OT ACTUAL - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Hour
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $actual_hour = $aortadb->query("EXEC zsp_get_real_hour '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->row();
                                            ?>

                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_01 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_02 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_03 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_04 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_05 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_06 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_07 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_08 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_09 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_10 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_11 / 60) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_12 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_13 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_14 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_15 / 60) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_16 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_17 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_18 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_19 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_20 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_21 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_22 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_23 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_24 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_25 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_26 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_27 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_28 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_29 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_30 / 60) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_hour->HOUR_31 / 60) ?>
                                            </td>
                                        </tr>
                                        <!-- OT ACTUAL - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $actual_amount = $aortadb->query("EXEC zsp_get_real_amount '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->row();
                                            ?>

                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_01) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_02) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_03) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_04) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_05) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_06) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_07) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_08) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_09) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_10) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_11) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_12) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_13) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_14) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_15) ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_16) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_17) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_18) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_19) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_20) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_21) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_22) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_23) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_24) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_25) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_26) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_27) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_28) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_29) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_30) ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo number_format($actual_amount->AMO_31) ?>
                                            </td>
                                        </tr>
                                        <!-- ACCUMULATIVE PLAN - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center;vertical-align: middle; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Accumulative Plan 
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                Hour
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>

                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $planning_hour = $aortadb->query("EXEC zsp_get_plan_hour '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->ROW();
                                            $planning_hour_accumulative = 0
                                            ?>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_01 / 60);
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_02 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_03 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_04 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_05 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_06 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_07 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_08 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_09 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_10 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_11 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_12 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_13 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_14 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_15 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_16 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_17 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_18 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_19 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_20 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_21 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_22 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_23 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_24 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_25 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_26 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_27 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_28 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_29 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_30 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_hour_accumulative = $planning_hour_accumulative + ($planning_hour->HOUR_31 / 60 );
                                                echo number_format($planning_hour_accumulative);
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- ACCUMULATIVE PLAN - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Accumulative Plan
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $planning_amount = $aortadb->query("EXEC zsp_get_plan_amount '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->ROW();
                                            $planning_amount_accumulative = 0;
                                            ?>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_01 / 60);
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_02 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_03 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_04 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_05 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_06 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_07 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_08 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_09 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_10 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_11 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_12 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_13 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_14 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_15 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_16 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_17 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_18 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_19 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_20 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_21 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_22 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_23 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_24 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_25 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_26 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_27 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_28 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_29 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_30 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $planning_amount_accumulative = $planning_amount_accumulative + ($planning_amount->AMO_31 / 60 );
                                                echo number_format($planning_amount_accumulative);
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- ACCUMULATIVE ACTUAL - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="2" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Accumulative Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Hour
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $actual_hour = $aortadb->query("EXEC zsp_get_real_hour '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->row();
                                            $actual_hour_accumulative = 0;
                                            ?>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_01 / 60);
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_02 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_03 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_04 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_05 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_06 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_07 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_08 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_09 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_10 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_11 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_12 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_13 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_14 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_15 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_16 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_17 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_18 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_19 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_20 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_21 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_22 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_23 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_24 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_25 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_26 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_27 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_28 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_29 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_30 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_31 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- ACCUMULATIVE ACTUAL - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                Accumulative Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $actual_amount = $aortadb->query("EXEC zsp_get_real_amount '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->row();
                                            $actual_amount_accumulative = 0;
                                            ?>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_01 / 60);
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_02 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_03 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_04 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_05 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_06 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_07 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_08 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_09 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_10 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_11 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_12 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_13 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_14 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_15 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_16 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_17 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_18 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_19 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_20 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_21 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_22 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_23 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_24 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_25 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_26 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_27 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_28 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_29 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_30 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_31 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- BALANCE OT PLAN VS ACTUAL - HOUR -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="1" style="text-align:right; background-color: #F3F4F5; vertical-align: middle;">
                                                Balance OT Plan vs Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Hour
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $actual_hour = $aortadb->query("EXEC zsp_get_real_hour '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->row();
                                            $actual_hour_accumulative = 0;
                                            ?>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_01 / 60);
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_02 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_03 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_04 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_05 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_06 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_07 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_08 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_09 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_10 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_11 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_12 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_13 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_14 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_15 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_16 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_17 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_18 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_19 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_20 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_21 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_22 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_23 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_24 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_25 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_26 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_27 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_28 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_29 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_30 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_31 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- BALANCE ACC PLAN VS ACTUAL - AMOUNT -->
                                        <tr>
                                            <td rowspan="" style="text-align:center; background-color: #F3F4F5; display: none;">
                                                <?php echo $value->NAMA_SECTION; ?>
                                            </td>
                                            <td rowspan="1" style="text-align:right; background-color: #F3F4F5; vertical-align: center;">
                                                Balance ACC Plan vs Actual
                                            </td>
                                            <td style="text-align:center;">
                                                Amount
                                            </td>
                                            <td rowspan="" style="text-align:center;">
                                                XX
                                            </td>
                                            
                                            <?php
                                            $kode_dept = $this->master_data_m->replacer_dept_prd($id_prod);
                                            $actual_amount = $aortadb->query("EXEC zsp_get_real_amount '$selected_date', '$kode_dept' , '" . $value->KODE . "'")->row();
                                            $actual_amount_accumulative = 0;
                                            ?>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_01 / 60);
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_02 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_03 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_04 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_05 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_06 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_07 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_08 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_09 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_10 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_amount_accumulative = $actual_amount_accumulative + ($actual_amount->AMO_11 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_12 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_13 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_14 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_15 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>

                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_16 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_17 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_18 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_19 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_20 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_21 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_22 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_23 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_24 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_25 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_26 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_27 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_28 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_29 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_30 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                $actual_hour_accumulative = $actual_hour_accumulative + ($actual_hour->HOUR_31 / 60 );
                                                echo number_format($actual_hour_accumulative);
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                            $(document).ready(function() {
                                                var table = $('#example').DataTable({
                                                    scrollY: "350px",
                                                    scrollX: true,
                                                    scrollCollapse: true,
                                                    paging: false,
                                                    fixedColumns: {
                                                        leftColumns: 4
                                                    }
                                                });
                                            });
</script>
                                            
   