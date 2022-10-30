<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<style type="text/css">

    #table-luar{
        font-size: 12px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border : 1px;
    }

    #testDiv{
        width: 100%;
        white-space: nowrap; 
        overflow-x:scroll;
        overflow-y:visible;
        font-size: 12px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION ENTRY</strong></a></li>
        </ol>
    </section>

    <section class="content">


        <?php
        $date = new DateTime($first_sunday);
        $thisMonth = $date->format('m');

        $x = 0;
        while ($date->format('m') === $thisMonth) {
            $datesunday[$x] = $date->format('j');
            $date->modify('next Sunday');
            $x++;
        }
        ?>

        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                            window.onload = function() {
                            var chart_quality = new CanvasJS.Chart("chartContainer_quality",
                            {
                            animationEnabled: true,
                                    title:{
                                    text: "" },
                                    axisX:{
                                    title: "Date",
                                            gridThickness: 1,
                                            interval: 1,
                                            stripLines:[

<?php
for ($a = 0; $a < $x; $a++) {
    if ($a == $x - 1) {
        ?>
                                                    {
                                                    startValue:<?php echo $datesunday[$a] - 1; ?>,
                                                            endValue:<?php echo $datesunday[$a]; ?>,
                                                            color:"#C23B22"
                                                    }
    <?php } else { ?>
                                                    {
                                                    startValue:<?php echo $datesunday[$a] - 1; ?>,
                                                            endValue:<?php echo $datesunday[$a]; ?>,
                                                            color:"#C23B22"
                                                    },
        <?php
    }
}
?>

                                            ],
                                            valueFormatString: "####" },
                                    axisY: {
                                    title: "Pcs",
                                            gridThickness: 1 },
                                    data: [ {
                                    type: "stackedColumn", //change type to bar, line, area, pie, etc
                                            color: "#00B050",
                                            showInLegend: "true",
                                            legendText: "OK Product",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "horizontal",
                                            dataPoints: [

<?php
$i = 1;
while ($i <= $sum_date_this_month) {
    $j = 0;
    foreach ($data_for_diagram_quality as $isi) {
        if ($i == intval($isi->CHR_DATE)) {
            if ($i != $sum_date_this_month) { {
                    ?>
                                                                { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY; ?> },
                    <?php
                    $j = $i;
                }
            } else {
                ?>
                                                            { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY; ?> }
                <?php
                $j = $i;
            }
        }
    }

    if ($j != $i) {
        if ($i != $sum_date_this_month) {
            ?>
                                                        { x: <?php echo $i; ?>, y: <?php echo 0; ?> },
        <?php } else { ?>
                                                        { x: <?php echo $i; ?>, y: <?php echo 0; ?> }
            <?php
        }
    }
    $i++;
}
?>
                                            ]
                                    },
                                    {
                                    type: "stackedColumn", //change type to bar, line, area, pie, etc
                                            color: "#FF0000",
                                            legendText: "Reject",
                                            showInLegend: "true",
                                            //indexLabel: "#total",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "horizontal",
                                            dataPoints: [

<?php
$i = 1;
while ($i <= $sum_date_this_month) {
    $j = 0;
    foreach ($data_for_diagram_quality as $isi) {
        if ($i == intval($isi->CHR_DATE)) {
            if ($i != $sum_date_this_month) { {
                    ?>
                                                                { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY_NG; ?> },
                    <?php
                    $j = $i;
                }
            } else {
                ?>
                                                            { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY_NG; ?> }
                <?php
                $j = $i;
            }
        }
    }

    if ($j != $i) {
        if ($i != $sum_date_this_month) {
            ?>
                                                        { x: <?php echo $i; ?>, y: <?php echo 0; ?> },
        <?php } else { ?>
                                                        { x: <?php echo $i; ?>, y: <?php echo 0; ?> }
            <?php
        }
    }
    $i++;
}
?>
                                            ]
                                    },
//                                                                                        {
//                                                                                        type: "line",
//                                                                                                showInLegend: true,
//                                                                                                lineDashType: "line",
//                                                                                                lineThickness: 2,
//                                                                                                color:"#1E90FF",
//                                                                                                markerType: "none",
//                                                                                                legendText: "Quality",
//                                                                                                dataPoints: [
//                                                                                                {x: 1, y: 50},
//                                                                                                {x: 2, y: 50},
//                                                                                                {x: 3, y: 50},
//                                                                                                {x: 4, y: 50},
//                                                                                                {x: 5, y: 50},
//                                                                                                {x: 6, y: 50},
//                                                                                                {x: 7, y: 50},
//                                                                                                {x: 8, y: 50},
//                                                                                                {x: 9, y: 50},
//                                                                                                {x: 10, y: 50},
//                                                                                                {x: 11, y: 50},
//                                                                                                {x: 12, y: 50},
//                                                                                                {x: 13, y: 50},
//                                                                                                {x: 14, y: 50},
//                                                                                                {x: 15, y: 50},
//                                                                                                {x: 16, y: 50},
//                                                                                                {x: 17, y: 50},
//                                                                                                {x: 18, y: 50},
//                                                                                                {x: 19, y: 50},
//                                                                                                {x: 20, y: 50},
//                                                                                                {x: 21, y: 50},
//                                                                                                {x: 22, y: 50},
//                                                                                                {x: 23, y: 50},
//                                                                                                {x: 24, y: 50},
//                                                                                                {x: 25, y: 50},
//                                                                                                {x: 26, y: 50},
//                                                                                                {x: 27, y: 50},
//                                                                                                {x: 28, y: 50},
//                                                                                                {x: 29, y: 50},
//                                                                                                {x: 30, y: 50}
//                                                                                                ]
//                                                                                        }
                                    ],
                                    legend: {
                                    cursor: "pointer",
                                            itemclick: function(e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                            e.dataSeries.visible = false;
                                            } else {
                                            e.dataSeries.visible = true;
                                            }
                                            chart_quality.render();
                                            }
                                    }
                            });
                                    chart_quality.render();
                            }
                </script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PROD. PERFORMANCE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <div class="pull-right grid-tools">
                                <?php echo form_open('pes_new/report_prod_perday_c/print_report_prod_entry', 'class="form-horizontal"'); ?>
                            </div>
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="15%">Periode</td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_perday_c/search_prod_entry/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod . '/' . $work_center); ?>"<?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>

                                    <td>Department</td>
                                    <td>
                                        <? if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 ) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedI n dex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" name="CHR_DEPT_SELECTED" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<? echo site_url('pes_new/report_prod_perday_c/search_prod_entry/' . $selected_date . '/' . $row->INT_ID_DEPT); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><? echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php if ($role != '3' && $role != '4') { ?>
                                            <button type="submit" name="submit" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                                        <?php } ?>
                                    </td>
                                <tr>
                                    <td>Work Center</td>
                                    <td> <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_perday_c/search_prod_entry/' . $selected_date . '/' . $id_prod . '/' . (trim($row->CHR_WORK_CENTER))); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div style='font-size: 14px;' class="pull-right">
<!--                                            <strong class='badge bg-blue'>TOTAL : <</strong>-->
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                        <input name="CHR_DEPT_SELECTED" value="<?php echo $id_prod ?>" type="hidden">
                        <input name="CHR_WC_SELECTED" value="<?php echo $work_center ?>" type="hidden">
                        <?php echo form_close() ?>

                        <?php if ($data_for_diagram_quality == 0) { ?>
                            <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer_quality" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM QUALITY-->

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                    var chart1;
                            $(document).ready(function () {
                    chart1 = new Highcharts.Chart({
                    chart: {
                    renderTo: 'container',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: ''
                            },
                            xAxis: {
                            categories: ['06:00-06:59', '07:00-07:59', '08:00-08:59', '09:00-09:59', '10:00-10:59', '11:00-11:59', 
                                        '12:00-12:59', '13:00-13:59', '14:00-14:59', '15:00-15:59', '16:00-16:59', '17:00-17:59', 
                                        '18:00-18:59', '19:00-06:59', '20:00-20:59', '21:00-21:59', '22:00-22:59', '23:00-23:59', 
                                        '00:00-00:59', '01:00-01:59', '02:00-02:59', '03:00-03:59', '04:00-04:59', '05:00-05:59']
                            },
                            yAxis: {
                            title: {
                            text: 'Productivity Per Hour'
                            }
                            },
                            series: [
<?php
foreach ($data_summary_inventory_by_date as $row) {
    ?>
                                {
                                name: '<?php echo $row->CHR_WORK_CENTER; ?>',
                                        data: [
    <?php
    echo $row->AM_06 . ',' . $row->AM_07 . ',' . $row->AM_08 . ',' . $row->AM_09 . ',' . $row->AM_10 . ',' . $row->AM_11 . ',' . $row->AM_12 . ',' . $row->AM_13 . ',' . $row->AM_14
    . ',' . $row->AM_15 . ',' . $row->AM_16 . ',' . $row->AM_17 . ',' . $row->AM_18 . ',' . $row->AM_19 . ',' . $row->AM_20 . ',' . $row->AM_21 . ',' . $row->AM_22
    . ',' . $row->AM_23 . ',' . $row->PM_00 . ',' . $row->PM_01 . ',' . $row->PM_02 . ',' . $row->PM_03 . ',' . $row->PM_04 . ',' . $row->PM_05;
    ?>
                                        ]
                                },
    <?php
}
?>
                            ]
                    });
                    });</script>

                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PROD PER HOUR LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container" style="height: 350px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->
        
        <!--GRID TO DISPLAY GRID TABLE-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PROD. PERFORMANCE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip"  title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="vertical-align: middle">No</th>
                                        <th style="vertical-align: middle">Work Center</th>
                                        <th style="vertical-align: middle">Part Number</th>
                                        <th style="vertical-align: middle">Back No </th>
    <!--                                        <th style="vertical-align: middle">Back No (Old)</th> -->
                                        <th style="vertical-align: middle">Part.Name & Model </th>
                                        <th style="vertical-align: middle">Date </th> 
    <!--                                        <th style="vertical-align: middle">Prod </th>-->
                                        <th style="vertical-align: middle">Shift </th> 										
                                        <th style="vertical-align: middle">Total OK </th>
                                        <th style="vertical-align: middle">Total NG </th>
                                        <th style="vertical-align: middle">Total </th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    $session = $this->session->all_userdata();
                                    foreach ($data_prod_entry as $isi) {

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_ONLY_DATE-$isi->CHR_ONLY_MONTH-$isi->CHR_ONLY_YEAR</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_SHIFT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL</td>";
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
        </div>

    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                                $(document).ready(function () {
                                        var table = $('#example1').DataTable({
                                        scrollY: "350px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: false,
                                                bFilter: false,
                                                fixedColumns: {
                                                leftColumns: 1
                                                }
                                        });
                                        });
                                                $(document).ready(function () {
                                        var table = $('#example2').DataTable({
                                        scrollY: "350px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                paging: false,
                                                bFilter: false,
                                                fixedColumns: {
                                                leftColumns: 1
                                                }
                                        });
                                        });
</script>