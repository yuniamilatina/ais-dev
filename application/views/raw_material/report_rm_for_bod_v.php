<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script type="text/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer",
                {
                    animationEnabled: true,
                    title: {
                        text: ""
                    },
                    axisX: {
                        title: "Date",
                        gridThickness: 2
                    },
                    axisY: {
                        title: "Quantity",
                        gridThickness: 2
                    },
                    data: [
                        {
                            click: function (e) {
                                alert("dataSeries Event => Type: " + e.dataSeries.type + ", dataPoint { x:" + e.dataPoint.x + ", y: " + e.dataPoint.y + " }");
                            },
                            type: "spline", //change type to bar, line, area, pie, etc
                            showInLegend: true,
                            legendText: "PROD",
//                            indexLabel: "{y}",
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "horizontal",
                            dataPoints: [
                                {x: 1, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_1 / 1000; ?>},
                                {x: 2, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_2 / 1000; ?>},
                                {x: 3, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_3 / 1000; ?>},
                                {x: 4, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_4 / 1000; ?>},
                                {x: 5, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_5 / 1000; ?>},
                                {x: 6, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_6 / 1000; ?>},
                                {x: 7, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_7 / 1000; ?>},
                                {x: 8, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_8 / 1000; ?>},
                                {x: 9, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_9 / 1000; ?>},
                                {x: 10, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_10 / 1000; ?>},
                                {x: 11, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_11 / 1000; ?>},
                                {x: 12, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_12 / 1000; ?>},
                                {x: 13, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_13 / 1000; ?>},
                                {x: 14, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_14 / 1000; ?>},
                                {x: 15, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_15 / 1000; ?>},
                                {x: 16, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_16 / 1000; ?>},
                                {x: 17, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_17 / 1000; ?>},
                                {x: 18, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_18 / 1000; ?>},
                                {x: 19, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_19 / 1000; ?>},
                                {x: 20, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_20 / 1000; ?>},
                                {x: 21, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_21 / 1000; ?>},
                                {x: 22, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_22 / 1000; ?>},
                                {x: 23, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_23 / 1000; ?>},
                                {x: 24, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_24 / 1000; ?>},
                                {x: 25, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_25 / 1000; ?>},
                                {x: 26, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_26 / 1000; ?>},
                                {x: 27, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_27 / 1000; ?>},
                                {x: 28, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_28 / 1000; ?>},
                                {x: 29, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_29 / 1000; ?>},
                                {x: 30, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_30 / 1000; ?>},
                                {x: 31, y: <?php echo $data_sum_movement_part->INT_SUM_PROD_31 / 1000; ?>}
                            ]
                        },
                        {
                            click: function (e) {
                                alert("dataSeries Event => Type: " + e.dataSeries.type + ", dataPoint { x:" + e.dataPoint.x + ", y: " + e.dataPoint.y + " }");
                            },
                            type: "spline", //change type to bar, line, area, pie, etc
                            showInLegend: true,
                            legendText: "CONS",
//                            indexLabel: "{y}",
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "horizontal",
                            dataPoints: [
                                {x: 1, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_1 / 1000; ?>},
                                {x: 2, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_2 / 1000; ?>},
                                {x: 3, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_3 / 1000; ?>},
                                {x: 4, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_4 / 1000; ?>},
                                {x: 5, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_5 / 1000; ?>},
                                {x: 6, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_6 / 1000; ?>},
                                {x: 7, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_7 / 1000; ?>},
                                {x: 8, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_8 / 1000; ?>},
                                {x: 9, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_9 / 1000; ?>},
                                {x: 10, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_10 / 1000; ?>},
                                {x: 11, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_11 / 1000; ?>},
                                {x: 12, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_12 / 1000; ?>},
                                {x: 13, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_13 / 1000; ?>},
                                {x: 14, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_14 / 1000; ?>},
                                {x: 15, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_15 / 1000; ?>},
                                {x: 16, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_16 / 1000; ?>},
                                {x: 17, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_17 / 1000; ?>},
                                {x: 18, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_18 / 1000; ?>},
                                {x: 19, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_19 / 1000; ?>},
                                {x: 20, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_20 / 1000; ?>},
                                {x: 21, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_21 / 1000; ?>},
                                {x: 22, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_22 / 1000; ?>},
                                {x: 23, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_23 / 1000; ?>},
                                {x: 24, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_24 / 1000; ?>},
                                {x: 25, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_25 / 1000; ?>},
                                {x: 26, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_26 / 1000; ?>},
                                {x: 27, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_27 / 1000; ?>},
                                {x: 28, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_28 / 1000; ?>},
                                {x: 29, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_29 / 1000; ?>},
                                {x: 30, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_30 / 1000; ?>},
                                {x: 31, y: <?php echo $data_sum_movement_part->INT_SUM_CONS_31 / 1000; ?>}
                            ]
                        },
                        {
                            click: function (e) {
                                alert("dataSeries Event => Type: " + e.dataSeries.type + ", dataPoint { x:" + e.dataPoint.x + ", y: " + e.dataPoint.y + " }");
                            },
                            type: "spline", //change type to bar, line, area, pie, etc
                            showInLegend: true,
                            legendText: "MOVE",
//                            indexLabel: "{y}",
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "horizontal",
                            dataPoints: [
                                {x: 1, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_1 / 1000; ?>},
                                {x: 2, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_2 / 1000; ?>},
                                {x: 3, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_3 / 1000; ?>},
                                {x: 4, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_4 / 1000; ?>},
                                {x: 5, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_5 / 1000; ?>},
                                {x: 6, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_6 / 1000; ?>},
                                {x: 7, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_7 / 1000; ?>},
                                {x: 8, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_8 / 1000; ?>},
                                {x: 9, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_9 / 1000; ?>},
                                {x: 10, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_10 / 1000; ?>},
                                {x: 11, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_11 / 1000; ?>},
                                {x: 12, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_12 / 1000; ?>},
                                {x: 13, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_13 / 1000; ?>},
                                {x: 14, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_14 / 1000; ?>},
                                {x: 15, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_15 / 1000; ?>},
                                {x: 16, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_16 / 1000; ?>},
                                {x: 17, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_17 / 1000; ?>},
                                {x: 18, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_18 / 1000; ?>},
                                {x: 19, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_19 / 1000; ?>},
                                {x: 20, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_20 / 1000; ?>},
                                {x: 21, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_21 / 1000; ?>},
                                {x: 22, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_22 / 1000; ?>},
                                {x: 23, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_23 / 1000; ?>},
                                {x: 24, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_24 / 1000; ?>},
                                {x: 25, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_25 / 1000; ?>},
                                {x: 26, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_26 / 1000; ?>},
                                {x: 27, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_27 / 1000; ?>},
                                {x: 28, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_28 / 1000; ?>},
                                {x: 29, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_29 / 1000; ?>},
                                {x: 30, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_30 / 1000; ?>},
                                {x: 31, y: <?php echo $data_sum_movement_part->INT_SUM_MOVE_31 / 1000; ?>}
                            ]
                        }
//                        ,
//                        {
//                            type: "spline",
//                            showInLegend: true,
//                            markerType: "none",
//                            dataPoints: [
//                                {x: 1, y: 50},
//                                {x: 2, y: 50},
//                                {x: 3, y: 50},
//                                {x: 4, y: 50},
//                                {x: 5, y: 50},
//                                {x: 6, y: 50},
//                                {x: 7, y: 50},
//                                {x: 8, y: 50},
//                                {x: 9, y: 50},
//                                {x: 10, y: 50},
//                                {x: 11, y: 50},
//                                {x: 12, y: 50},
//                                {x: 13, y: 50},
//                                {x: 14, y: 50},
//                                {x: 15, y: 50},
//                                {x: 16, y: 50},
//                                {x: 17, y: 50},
//                                {x: 18, y: 50},
//                                {x: 19, y: 50},
//                                {x: 20, y: 50},
//                                {x: 21, y: 50},
//                                {x: 22, y: 50},
//                                {x: 23, y: 50},
//                                {x: 24, y: 50},
//                                {x: 25, y: 50},
//                                {x: 26, y: 50},
//                                {x: 27, y: 50},
//                                {x: 28, y: 50},
//                                {x: 29, y: 50},
//                                {x: 30, y: 50},
//                                {x: 31, y: 50}
//                            ]
//                        }
                    ],
                    legend: {
                        cursor: "pointer",
                        itemclick: function (e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } else {
                                e.dataSeries.visible = true;
                            }
                            chart.render();
                        }
                    }
                });

        chart.render();
    }
</script>
<style type="text/css">
    #testDiv{
        width: 100%;
        overflow-x: auto;
        white-space: nowrap; 
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT BOD</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- BEGIN LINE CHART -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title">Monitoring Stock Raw Material</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <!-- BEGIN LIVE CHART -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">Table Report Movement</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('raw_material/raw_material_coil_c/bod', 'class="form-horizontal"'); ?> 

                            <select name="INT_ID_MONTH" id="INT_ID_MONTH" class="ddl">
                                <?php
                                for ($x = 1; $x < 13; $x++) {
                                    if ($month_desc[$x] == $selected_month) {
                                        ?>
                                        <option selected="true" value="<?php echo $x; ?>"><?php echo $month_desc[$x]; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $x; ?>"><?php echo $month_desc[$x]; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <select name="INT_ID_YEAR" id="INT_ID_YEAR" class="ddl">
                                <option selected="true" value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                            </select>

                            <button type="submit" name="btn_submit" id="btn_submit" value="1" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px"><i class="fa fa-search"></i></button>
                            <?php echo form_close(); ?>

                        </div>

                        <div id="testDiv">
                            <table id="dataTables3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle">No</th>
                                        <th rowspan="2" style="vertical-align: middle">Part Number</th>
                                        <?php
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<th colspan='3' style=text-align:center;>$x</th>";
                                        }
                                        ?>
                                        <th rowspan="2" style="vertical-align: middle">Total Prod </th>                                        
                                        <th rowspan="2" style="vertical-align: middle">Total Cons </th>
                                        <th rowspan="2" style="vertical-align: middle">Total Move </th>
                                        <th colspan='3' style=text-align:center;>Balance </th>

                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td >Prod</td>";
                                            echo "<td >Cons</td>";
                                            echo "<td >Move</td>";
                                        }
                                        ?>
                                        <td >Beginning</td>
                                        <td >Ending</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_movement_part as $isi) {

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NUMBER</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_1 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_2 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_3 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_4 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_5 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_6 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_7 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_8 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_9 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_10 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_11 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_12 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_13 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_14 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_15 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_16 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_17 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_18 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_19 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_20 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_21 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_22 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_23 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_24 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_25 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_26 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_27 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_28 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_29 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_30 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_31 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_31 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_31 / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_PROD_TOT / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_CONS_TOT / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_MOVE_TOT / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_SALDO_AWAL / 1000) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_SALDO_AKHIR / 1000) . "</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
            <!-- END LIVE CHART -->
        </div>


    </section>
    <!-- END MAIN CONTENT -->
</aside>






