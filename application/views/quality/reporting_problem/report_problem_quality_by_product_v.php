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

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>QUALITY PROBLEM REPORT</strong></a></li>
        </ol>
    </section>

    <section class="content">
        
        <div class="row">
            <div class="col-md-12">
                <!-- REPORT OVERTIME BY HOUR -->
                <script type="text/javascript">
                    window.onload = function () {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme2",
                                    //animationEnabled: true,
                                    title: {
                                        //text: "",
                                        //fontSize: 30
                                    },                                    
                                    axisY: {
                                        title: "QTY Case",
                                        gridThickness:0.2,
                                        interval: 5
                                    },
                                    axisY2: {
                                        title: "QTY Percentage (%)",
                                        interval: 10,
                                        includeZero : true
                                    },
                                    axisX: {
                                        labelFontSize: 11,
                                        interval: 1,
                                        labelAngle: 45
                                    },
                                    data: [
                                        {
                                            type: "column",
                                            dataPoints: [
<?php
$count = count($data_by_product);
$row = 1;
foreach ($data_by_product as $isi) {
    if ($row != $count) {
        echo '{label: "' . $isi->CHR_BACK_NO . '", y:' . $isi->QTY_CASE . '},';
        $row++;
    } else {
        echo '{label: "' . $isi->CHR_BACK_NO . '", y:' . $isi->QTY_CASE . '}';
    }
}
?>
                                            ]
                                        },
                                        {
                                            type: "line",
                                            axisYType: "secondary",
                                            dataPoints: [
<?php
$count = count($pareto_product);
$row = 1;
$qty_before = 0;
foreach ($pareto_product as $isi) {
    $qty_sum = $isi->PERCENTAGE + $qty_before;
    if ($row != $count) {        
        echo '{label: "' . $isi->CHR_BACK_NO . '", y:' . $qty_sum . '},';
        $qty_before = $qty_sum;
        $row++;
    } else {
        echo '{label: "' . $isi->CHR_BACK_NO . '", y:' . $qty_sum . '}';
    }
}
?>
                                                
                                            ]
                                        }
                                    ],
                                    legend: {
                                        cursor: "pointer",
                                        itemclick: function (e) {
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
                        <span class="grid-title">PROBLEM REPORT BY <strong>PRODUCT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="5%"><strong>Periode</strong></td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . date("Ym", strtotime("+$x month")) . '/ALL/ALL'); ?>" <?php
                                                if ($date_selected == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%"><strong>Back No Product</strong></td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL'); ?>">ALL</option>
                                            <?php foreach ($data_by_product as $data) { ?>
                                                <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/' . $data->CHR_BACK_NO . '/' . $section); ?>" <?php
                                                if ($back_no == $data->CHR_BACK_NO) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo $data->CHR_BACK_NO; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="5%"><strong>Status TR</strong></td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php
                                                if ($status == ''){
                                            ?>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/ALL'); ?>" selected>ALL</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/0'); ?>">No Follow Up</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/1'); ?>">Temp Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/2'); ?>">Fix Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/3'); ?>">Closed</option>
                                            <?php 
                                                } else if ($status == '0'){
                                            ?>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/ALL'); ?>">ALL</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/0'); ?>" selected>No Follow Up</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/1'); ?>">Temp Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/2'); ?>">Fix Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/3'); ?>">Closed</option>
                                            <?php
                                                } else if ($status == '1'){
                                            ?>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/ALL'); ?>">ALL</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/0'); ?>">No Follow Up</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/1'); ?>" selected>Temp Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/2'); ?>">Fix Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/3'); ?>">Closed</option>
                                            <?php
                                                } else if ($status == '2'){
                                            ?>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/ALL'); ?>">ALL</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/0'); ?>">No Follow Up</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/1'); ?>">Temp Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/2'); ?>" selected>Fix Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/3'); ?>">Closed</option>
                                            <?php
                                                } else {
                                            ?>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/ALL'); ?>">ALL</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/0'); ?>">No Follow Up</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/1'); ?>">Temp Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/2'); ?>">Fix Action</option>
                                            <option value="<?php echo site_url('quality/quality_problem_c/report_by_product/' . $date_selected . '/ALL/ALL/3'); ?>" selected>Closed</option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            </table>
                        </div>
                        <?php if ($data_by_product == null) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>
                    
                </div>
            </div>
        </div>
        
        <?php
            if ($back_no == NULL || $back_no == ''){
                $back_no = 'ALL';
            }
            
            if ($section == NULL || $section == ''){
                $section = 'ALL';
            }
            
            if ($status == NULL || $status == ''){
                $status = 'ALL';
            }
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title">PROBLEM REPORT BY <strong>PRODUCT</strong> PER DAY</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>                
                    <div class="grid-body">
                        <iframe scrolling="no" frameBorder="0" style="width:100%;min-height:400px;overflow:hidden;" width=100% height=100% src="<?php echo site_url("quality/quality_problem_c/report_by_product_per_day/$date_selected/$back_no/$section/$status"); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</aside>
