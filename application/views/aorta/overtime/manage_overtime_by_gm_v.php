<!-- <script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script> -->
<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

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

<script type="text/javascript">
    var chart1;
    $(document).ready(function() {
        chart1 = new Highcharts.Chart({
            chart: {
                renderTo: 'chartPlanActualQuota',
                zoomType: 'xy',
                plotBorderWidth: 0
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: true,
                // align: 'right',
                // verticalAlign: 'top',
                borderWidth: 0,
                x: 0,
                y: 0
            },
            title: {
                text: ''
            },
            xAxis: {
                // gridLineColor:'#392C4E',
                gridLineWidth: 0,
                min: 0,
                offset: 0,
                tickmarkPlacement: 'on',
                labels: {
                    style: {
                        color: '#9E9E9E',
                        fontSize: '11px'
                    },
                },
                plotBands: [
                    <?php
                    for ($a = 0; $a < $x; $a++) {
                        if ($a == $x - 2) {
                    ?> {
                                from: <?php echo $datesunday[$a] - 2; ?>,
                                to: <?php echo $datesunday[$a] - 1; ?>,
                                color: 'rgba(255, 170, 213, .2)'
                            },
                        <?php } else { ?> {
                                from: <?php echo $datesunday[$a] - 2; ?>,
                                to: <?php echo $datesunday[$a] - 1; ?>,
                                color: 'rgba(255, 170, 213, .2)'
                            },
                    <?php
                        }
                    }
                    ?>
                ],
                categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]
            },
            yAxis: {
                // gridLineColor: '#392C4E',
                gridLineWidth: 1,
                min: 0,
                offset: 0,
                title: {
                    text: ''
                },
                labels: {
                    enabled: false,
                    style: {
                        color: '#9E9E9E',
                        fontSize: '10px'
                    }
                }
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        style: {
                            textOutline: false,
                            fontSize: '10px',
                            fontWeight: false
                        },
                        format: '{point.y:.2f}'
                    }
                }
            },
            tooltip: {
                pointFormat: '<span style="font-size:11px;">{series.name}</span>: <b>{point.y:.2f} </b><br/>',
                shared: true,
                crosshairs: true
            },
            series: [

                {
                    name: 'Actual Overtime',
                    color: '#0666c2',
                    type: 'column',
                    data: [
                        <?php echo $actl->DATE_01; ?>,
                        <?php echo $actl->DATE_02; ?>,
                        <?php echo $actl->DATE_03; ?>,
                        <?php echo $actl->DATE_04; ?>,
                        <?php echo $actl->DATE_05; ?>,
                        <?php echo $actl->DATE_06; ?>,
                        <?php echo $actl->DATE_07; ?>,
                        <?php echo $actl->DATE_08; ?>,
                        <?php echo $actl->DATE_09; ?>,
                        <?php echo $actl->DATE_10; ?>,
                        <?php echo $actl->DATE_11; ?>,
                        <?php echo $actl->DATE_12; ?>,
                        <?php echo $actl->DATE_13; ?>,
                        <?php echo $actl->DATE_14; ?>,
                        <?php echo $actl->DATE_15; ?>,
                        <?php echo $actl->DATE_16; ?>,
                        <?php echo $actl->DATE_17; ?>,
                        <?php echo $actl->DATE_18; ?>,
                        <?php echo $actl->DATE_19; ?>,
                        <?php echo $actl->DATE_20; ?>,
                        <?php echo $actl->DATE_21; ?>,
                        <?php echo $actl->DATE_22; ?>,
                        <?php echo $actl->DATE_23; ?>,
                        <?php echo $actl->DATE_24; ?>,
                        <?php echo $actl->DATE_25; ?>,
                        <?php echo $actl->DATE_26; ?>,
                        <?php echo $actl->DATE_27; ?>,
                        <?php echo $actl->DATE_28; ?>,
                        <?php echo $actl->DATE_29; ?>,
                        <?php echo $actl->DATE_30; ?>,
                        <?php echo $actl->DATE_31; ?>
                    ]
                },
                {
                    name: 'Quota Plan',
                    color: '#FFCA01',
                    type: 'line',
                    data: [
                        <?php echo $plan->DATE_01; ?>,
                        <?php echo $plan->DATE_02; ?>,
                        <?php echo $plan->DATE_03; ?>,
                        <?php echo $plan->DATE_04; ?>,
                        <?php echo $plan->DATE_05; ?>,
                        <?php echo $plan->DATE_06; ?>,
                        <?php echo $plan->DATE_07; ?>,
                        <?php echo $plan->DATE_08; ?>,
                        <?php echo $plan->DATE_09; ?>,
                        <?php echo $plan->DATE_10; ?>,
                        <?php echo $plan->DATE_11; ?>,
                        <?php echo $plan->DATE_12; ?>,
                        <?php echo $plan->DATE_13; ?>,
                        <?php echo $plan->DATE_14; ?>,
                        <?php echo $plan->DATE_15; ?>,
                        <?php echo $plan->DATE_16; ?>,
                        <?php echo $plan->DATE_17; ?>,
                        <?php echo $plan->DATE_18; ?>,
                        <?php echo $plan->DATE_19; ?>,
                        <?php echo $plan->DATE_20; ?>,
                        <?php echo $plan->DATE_21; ?>,
                        <?php echo $plan->DATE_22; ?>,
                        <?php echo $plan->DATE_23; ?>,
                        <?php echo $plan->DATE_24; ?>,
                        <?php echo $plan->DATE_25; ?>,
                        <?php echo $plan->DATE_26; ?>,
                        <?php echo $plan->DATE_27; ?>,
                        <?php echo $plan->DATE_28; ?>,
                        <?php echo $plan->DATE_29; ?>,
                        <?php echo $plan->DATE_30; ?>,
                        <?php echo $plan->DATE_31; ?>
                    ]
                }
            ]
        });
    });
</script>
<script type="text/javascript">
    var chart2;
    $(document).ready(function() {
        chart2 = new Highcharts.Chart({
            chart: {
                renderTo: 'chartPlanActualQuotaCum',
                zoomType: 'xy',
                plotBorderWidth: 0,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: true,
                // align: 'right',
                // verticalAlign: 'top',
                borderWidth: 0,
                x: 0,
                y: 0
            },
            title: {
                text: ''
            },
            xAxis: {
                // gridLineColor:'#392C4E',
                gridLineWidth: 0,
                min: 0,
                offset: 0,
                tickmarkPlacement: 'on',
                labels: {
                    style: {
                        color: '#9E9E9E',
                        fontSize: '11px'
                    },
                },
                plotBands: [
                    <?php
                    for ($a = 0; $a < $x; $a++) {
                        if ($a == $x - 2) {
                    ?> {
                                from: <?php echo $datesunday[$a] - 2; ?>,
                                to: <?php echo $datesunday[$a] - 1; ?>,
                                color: 'rgba(255, 170, 213, .2)'
                            },
                        <?php } else { ?> {
                                from: <?php echo $datesunday[$a] - 2; ?>,
                                to: <?php echo $datesunday[$a] - 1; ?>,
                                color: 'rgba(255, 170, 213, .2)'
                            },
                    <?php
                        }
                    }
                    ?>
                ],
                categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]
            },
            yAxis: {
                // gridLineColor: '#392C4E',
                gridLineWidth: 1,
                min: 0,
                offset: 0,
                title: {
                    text: ''
                },
                labels: {
                    enabled: false,
                    style: {
                        color: '#9E9E9E',
                        fontSize: '10px'
                    }
                }
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        style: {
                            textOutline: false,
                            fontSize: '10px',
                            fontWeight: false
                        },
                        format: '{point.y:.2f}'
                    }
                }
            },
            tooltip: {
                pointFormat: '<span style="font-size:11px;">{series.name}</span>: <b>{point.y:.2f} </b><br/>',
                shared: true,
                crosshairs: true
            },
            series: [{
                    name: 'Actual Overtime',
                    color: '#0666c2',
                    type: 'line',
                    data: [
                        <?php echo $actl_cum->DATE_01; ?>,
                        <?php echo $actl_cum->DATE_02; ?>,
                        <?php echo $actl_cum->DATE_03; ?>,
                        <?php echo $actl_cum->DATE_04; ?>,
                        <?php echo $actl_cum->DATE_05; ?>,
                        <?php echo $actl_cum->DATE_06; ?>,
                        <?php echo $actl_cum->DATE_07; ?>,
                        <?php echo $actl_cum->DATE_08; ?>,
                        <?php echo $actl_cum->DATE_09; ?>,
                        <?php echo $actl_cum->DATE_10; ?>,
                        <?php echo $actl_cum->DATE_11; ?>,
                        <?php echo $actl_cum->DATE_12; ?>,
                        <?php echo $actl_cum->DATE_13; ?>,
                        <?php echo $actl_cum->DATE_14; ?>,
                        <?php echo $actl_cum->DATE_15; ?>,
                        <?php echo $actl_cum->DATE_16; ?>,
                        <?php echo $actl_cum->DATE_17; ?>,
                        <?php echo $actl_cum->DATE_18; ?>,
                        <?php echo $actl_cum->DATE_19; ?>,
                        <?php echo $actl_cum->DATE_20; ?>,
                        <?php echo $actl_cum->DATE_21; ?>,
                        <?php echo $actl_cum->DATE_22; ?>,
                        <?php echo $actl_cum->DATE_23; ?>,
                        <?php echo $actl_cum->DATE_24; ?>,
                        <?php echo $actl_cum->DATE_25; ?>,
                        <?php echo $actl_cum->DATE_26; ?>,
                        <?php echo $actl_cum->DATE_27; ?>,
                        <?php echo $actl_cum->DATE_28; ?>,
                        <?php echo $actl_cum->DATE_29; ?>,
                        <?php echo $actl_cum->DATE_30; ?>,
                        <?php echo $actl_cum->DATE_31; ?>
                    ]
                }, {
                    name: 'Quota Plan',
                    color: '#FFCA01',
                    type: 'line',
                    data: [
                        <?php echo $plan_cum->DATE_01; ?>,
                        <?php echo $plan_cum->DATE_02; ?>,
                        <?php echo $plan_cum->DATE_03; ?>,
                        <?php echo $plan_cum->DATE_04; ?>,
                        <?php echo $plan_cum->DATE_05; ?>,
                        <?php echo $plan_cum->DATE_06; ?>,
                        <?php echo $plan_cum->DATE_07; ?>,
                        <?php echo $plan_cum->DATE_08; ?>,
                        <?php echo $plan_cum->DATE_09; ?>,
                        <?php echo $plan_cum->DATE_10; ?>,
                        <?php echo $plan_cum->DATE_11; ?>,
                        <?php echo $plan_cum->DATE_12; ?>,
                        <?php echo $plan_cum->DATE_13; ?>,
                        <?php echo $plan_cum->DATE_14; ?>,
                        <?php echo $plan_cum->DATE_15; ?>,
                        <?php echo $plan_cum->DATE_16; ?>,
                        <?php echo $plan_cum->DATE_17; ?>,
                        <?php echo $plan_cum->DATE_18; ?>,
                        <?php echo $plan_cum->DATE_19; ?>,
                        <?php echo $plan_cum->DATE_20; ?>,
                        <?php echo $plan_cum->DATE_21; ?>,
                        <?php echo $plan_cum->DATE_22; ?>,
                        <?php echo $plan_cum->DATE_23; ?>,
                        <?php echo $plan_cum->DATE_24; ?>,
                        <?php echo $plan_cum->DATE_25; ?>,
                        <?php echo $plan_cum->DATE_26; ?>,
                        <?php echo $plan_cum->DATE_27; ?>,
                        <?php echo $plan_cum->DATE_28; ?>,
                        <?php echo $plan_cum->DATE_29; ?>,
                        <?php echo $plan_cum->DATE_30; ?>,
                        <?php echo $plan_cum->DATE_31; ?>
                    ]
                }

            ]
        });
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/aorta/overtime_c') ?>"><strong>Manage Overtime </strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>PLAN VS ACTUAL - <?php echo $dept . ' ' . $section; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/aorta/quota_employee_c/downloadViewPlanActualQuota/' . $period . '/' . $dept . '/' . $section); ?>" data-placement="left" data-toggle="tooltip" title="Export to Excel"><i class="fa fa-download"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chartPlanActualQuota" style="height: 200px; width:100%; margin: 0 auto;"></div>
                        <div style="overflow:auto">
                            <table id='datatables2' class="table table-condensed display" cellspacing="0" width="100%" style=" font-size: 9px;padding-left:-0.5em;padding-right:-0.5em;">
                                <thead>
                                    <tr>
                                        <?php for ($y = 1; $y <= 31; $y++) {
                                            $color = '';
                                            for ($a = 0; $a < $x; $a++) {
                                                if ($datesunday[$a] == $y + 1 || $datesunday[$a] == $y) {
                                                    $color = "background:#f45348;color:#FFF;";
                                                } ?>
                                            <?php } ?>

                                            <td style="font-weight: bold;text-align:center;<?php echo $color; ?>"><?php echo $y; ?></td>

                                        <?php } ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo "<tr style='background:rgba(250, 218, 94, .2);'>";
                                    // echo "<td style='text-align:center;'>PLAN</td>";
                                    if ($plan->DATE_01 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_01, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_02 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_02, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_03 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_03, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_04 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_04, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_05 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_05, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_06 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_06, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_07 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_07, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_08 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_08, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_09 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_09, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_10 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_10, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_11 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_11, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_12 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_12, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_13 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_13, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_14 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_14, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_15 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_15, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_16 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_16, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_17 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_17, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_18 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_18, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_19 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_19, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_20 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_20, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_21 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_21, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_22 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_22, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_23 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_23, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_24 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_24, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_25 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_25, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_26 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_26, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_27 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_27, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_28 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_28, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_29 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_29, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_30 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_30, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan->DATE_31 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan->DATE_31, 0, ',', '.') . "</td>";
                                    }
                                    echo "</tr>";

                                    echo "<tr style='background:rgba(52, 183, 241, .2);'>";
                                    // echo "<td style='text-align:center;'>ACTL</td>";
                                    if ($actl->DATE_01 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_01, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_02 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_02, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_03 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_03, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_04 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_04, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_05 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_05, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_06 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_06, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_07 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_07, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_08 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_08, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_09 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_09, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_10 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_10, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_11 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_11, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_12 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_12, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_13 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_13, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_14 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_14, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_15 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_15, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_16 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_16, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_17 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_17, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_18 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_18, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_19 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_19, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_20 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_20, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_21 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_21, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_22 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_22, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_23 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_23, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_24 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_24, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_25 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_25, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_26 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_26, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_27 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_27, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_28 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_28, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_29 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_29, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_30 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_30, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl->DATE_31 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl->DATE_31, 0, ',', '.') . "</td>";
                                    }
                                    echo "</tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <iframe frameBorder="0" width='100%' height='350px' src="<?php echo site_url("aorta/quota_employee_c/view_plan_vs_actual_quota/" . $period . "/" . $dept . "/" . $section); ?>"></iframe> -->
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>CUM. PLAN VS ACTUAL - <?php echo $dept . ' ' . $section; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/aorta/quota_employee_c/downloadViewPlanActualQuotaAccumulative/' . $period . '/' . $dept . '/' . $section); ?>"  data-placement="left" data-toggle="tooltip" title="Export to Excel"><i class="fa fa-download"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="chartPlanActualQuotaCum" style="height: 200px; margin: 0 auto;"></div>
                        <div style="overflow:auto">
                            <table id='datatables1' class="table table-condensed display" cellspacing="0" width="100%" style="font-size: 9px;padding-left:-0.5em;padding-right:-0.5em;">
                                <thead>
                                    <tr>
                                        <?php for ($y = 1; $y <= 31; $y++) {
                                            $color = '';
                                            for ($a = 0; $a < $x; $a++) {
                                                if ($datesunday[$a] == $y + 1 || $datesunday[$a] == $y) {
                                                    $color = "background:#f45348;color:#FFF;";
                                                } ?>
                                            <?php } ?>

                                            <td style="font-weight: bold;text-align:center;<?php echo $color; ?>"><?php echo $y; ?></td>

                                        <?php } ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo "<tr style='background:rgba(250, 218, 94, .2);'>";
                                    // echo "<td style='text-align:center;'>PLAN</td>";
                                    if ($plan_cum->DATE_01 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_01, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_02 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_02, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_03 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_03, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_04 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_04, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_05 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_05, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_06 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_06, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_07 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_07, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_08 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_08, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_09 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_09, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_10 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_10, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_11 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_11, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_12 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_12, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_13 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_13, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_14 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_14, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_15 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_15, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_16 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_16, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_17 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_17, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_18 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_18, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_19 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_19, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_20 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_20, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_21 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_21, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_22 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_22, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_23 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_23, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_24 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_24, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_25 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_25, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_26 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_26, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_27 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_27, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_28 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_28, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_29 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_29, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_30 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_30, 0, ',', '.') . "</td>";
                                    }
                                    if ($plan_cum->DATE_31 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($plan_cum->DATE_31, 0, ',', '.') . "</td>";
                                    }
                                    echo "</tr>";

                                    echo "<tr style='background:rgba(52, 183, 241, .2);'>";
                                    // echo "<td style='text-align:center;'>ACTL</td>";
                                    if ($actl_cum->DATE_01 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_01, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_02 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_02, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_03 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_03, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_04 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_04, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_05 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_05, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_06 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_06, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_07 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_07, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_08 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_08, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_09 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_09, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_10 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_10, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_11 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_11, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_12 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_12, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_13 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_13, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_14 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_14, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_15 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_15, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_16 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_16, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_17 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_17, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_18 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_18, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_19 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_19, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_20 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_20, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_21 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_21, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_22 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_22, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_23 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_23, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_24 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_24, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_25 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_25, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_26 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_26, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_27 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_27, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_28 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_28, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_29 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_29, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_30 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_30, 0, ',', '.') . "</td>";
                                    }
                                    if ($actl_cum->DATE_31 == 0) {
                                        echo "<td style='text-align:center;'>-</td>";
                                    } else {
                                        echo "<td style='text-align:center;'>" . number_format($actl_cum->DATE_31, 0, ',', '.') . "</td>";
                                    }
                                    echo "</tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <iframe frameBorder="0" width='100%' height='350px' src="<?php echo site_url("aorta/quota_employee_c/view_plan_vs_actual_quota_accumulation/" . $period . "/" . $dept . "/" . $section); ?>"></iframe> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>APPROVAL OVERTIME - GROUP MANAGER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                        <?php if ($dept == '-') {
                            echo '-';
                        } else if ($dept == 'MIS' || $dept == 'MSU' || $dept == 'PCO' || $dept == 'QUA' || $dept == 'PPC') {?> 
                            <div style="width: 100%;">
                                <table style="background:#fce0de;color:#85172d;" width="100%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                    <tr>
                                        <th style='text-align:left;font-size:14px;' colspan="4"><strong>Noted : </strong></th>
                                    </tr>
                                    <tr>
                                        <td style='text-align:left;font-size:12px;' colspan="4"><b>Planing</b> untuk approval planing overtime, sedangkan <b>Realization</b> untuk approval realisasi overtime.</td>
                                    </tr>
                                    <tr>
                                        <td style='text-align:left;font-size:12px;' colspan="4">Apabila menekan tombol approval realisasi, maka otomatis approval planing juga disetujui!</td>
                                    </tr>
                                </table>
                            </div>   
                        <?php } else { ?>   
                            <div></div>
                        <?php } ?>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Periode / Dept / Section</strong></td>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -3; $x <= 1; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('aorta/overtime_c/prepare_approve_ot_by_gm/' . date("Ym", strtotime("+$y day")) . '/' . trim($dept) . '/' . $section); ?>" <?php
                                                                                                                                                                                                                if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>> <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                            <?php } ?>

                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_gm/' . $period . '/' . trim($row->CHR_DEPT) . '/' . trim($section)); ?>" <?php
                                                                                                                                                                                                    if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_gm/' . $period . '/' . trim($dept) . '/' . trim($row->KODE)); ?>" <?php
                                                                                                                                                                                            if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="50%">

                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                            </table>
                        </div>

                        <?php echo form_open('aorta/overtime_c/approve_all_overtime_by_gm', 'class="form-horizontal"'); ?>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">No SPKL</th>
                                        <th style="text-align:center;">OT Description</th>
                                        <th style="text-align:center;">Total MP</th>
                                        <th style="text-align:center;">Plan OT (H)</th>
                                        <?php
                                            if($dept == 'MIS' || $dept == 'MSU' || $dept == 'PCO' || $dept == 'QUA' || $dept == 'PPC'){
                                                echo "<th style='text-align:center;'>Planing</th>";
                                            } else{
                                                echo "<th style='text-align:center;'>Action</th>";
                                            }
                                        ?>
                                        <th style="text-align:center;">Realization</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        if ($isi->CEK_KADEP == 1 && $isi->CEK_GM == 0) {
                                            $color = 'background:#E63F53;color:#fff;';
                                            $display = 'enabled';
                                        }
                                        if ($isi->CEK_KADEP == 1 && $isi->CEK_GM == 1) {
                                            $color = 'background:#7DD488;color:#fff;';
                                            $display = 'disabled';
                                        }
                                        if ($isi->CEK_GM == 1 && $isi->FLG_DOWNLOAD == 1) {
                                            $color = 'background:#71AEF5;color:#fff;';
                                            $display = 'disabled';
                                        }
                                        if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                            $color = '';
                                            $display = 'disabled';
                                        }

                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:right;'><input class='icheck' $display type='checkbox' name='nospkl[]' id='nospkl' value='$isi->NO_SEQUENCE'></td>";
                                        echo "<td style='text-align:center;'>$i</td>";

                                        echo "<td style='$color'>$isi->NO_SEQUENCE</td>";
                                        if (strlen($isi->ALASAN) > 70) {
                                            echo "<td>" . substr($isi->ALASAN, 0, 70) . " ...</td>";
                                        } else {
                                            echo "<td>" . $isi->ALASAN . "</td>";
                                        }
                                        echo "<td align='center'><strong>$isi->TOT_MP</strong></td>";
                                        echo "<td align='center'><strong>" . number_format($isi->RENC_DURASI_OV_TIME, 2, ',', '.') . "</strong></td>";
                                    ?>
                                        <!-- <td>
                                            <?php
                                            if ($isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td> -->

                                        <?php if ($dept == '-') {
                                            echo '-';
                                        } else if ($dept == 'MIS' || $dept == 'MSU' || $dept == 'PCO' || $dept == 'QUA' || $dept == 'PPC') {?>
                                        <td align='center'>
                                            <?php
                                            if ($isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ( $isi->CEK_GM_PLAN == 0 && $isi->CEK_GM == 0) {
                                            ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_plan_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime planing with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_plan_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime planingwith code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        <td align='center' >
                                            <?php
                                            if ($isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime planing with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime planingwith code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        <?php } else { ?>
                                            <td align='center'>
                                            <?php
                                            if ($isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ( $isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                            <?php } ?>
                                        </td>
                                        <td align='center' >
                                            <?php
                                            if ($isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_GM == 0) {
                                            ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime planing with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime planingwith code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d (Realization): </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#E63F53;width:25px;height:25px;color:white;'></button> : Not Yet Approved
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#7DD488;width:25px;height:25px;color:white;'></button> : Approved
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#71AEF5;width:25px;height:25px;color:white;' ></button> : Process by HRD
                                        <span style = "font-size: 9px; color:gray;">(MIS, MSU, PCO, QUA, PPC)</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pull-right" style="margin-top: -30px;">

                            <input name="CHR_DEPT_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo trim($dept) ?>">
                            <input name="CHR_PERIOD_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                            <input name="CHR_SECTION_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">

                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve all Overtime" onclick="return confirm('Are you sure want to Approve all overtime in this dept and this period');"><i class="fa fa-thumbs-up"></i> Approve All</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>

                <?php
                $array_qr = 0;
                $id_qrcode[$array_qr] = 0;
                foreach ($data as $isi) {
                    if ($id_qrcode[$array_qr] != $isi->NO_SEQUENCE) {
                        $id_qrcode[$array_qr] = $isi->NO_SEQUENCE;
                ?>

                        <div class="modal fade" id="modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Overtime No : <?php echo $isi->NO_SEQUENCE ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('aorta/overtime_c/approve_form_overtime_by_gm', 'class="form-horizontal"'); ?>

                                            <input name="NO_SEQUENCE" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->NO_SEQUENCE ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_PERIOD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                                            <input name="CHR_SECTION" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">

                                            <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                                <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Date</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Username</th>
                                                            <th rowspan="2" style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Sub Section</th>

                                                            <th style="vertical-align: middle;text-align:center;" colspan="4">Quota (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Planning (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Realization (H)</th>

                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC Name</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Std</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Plan</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Real</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Saldo</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Start</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Start</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                        </tr>

                                                    </thead>
                                                    <tbody id="data_detail<?php echo $isi->NO_SEQUENCE ?>">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <?php if ($isi->CEK_GM == 0) { ?>
                                                    <button type="submit" value=1 name="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve This Quota Request" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                <?php } else { ?>
                                                    <button type="submit" value=0 name="submit" class="btn btn-danger" data-placement="left" data-toggle="tooltip" title="Unapprove This Quota Request" onclick="return confirm('Are you sure want to Unapprove this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-down"></i> Unapprove</button>
                                                <?php } ?>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                        $array_qr++;
                    }
                    $id_qrcode[$array_qr] = 0;
                }
                ?>

                <div class="modal fade" id="modalQuota" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header  bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Quota Usage per Dept</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                        <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;text-align:center;">No</th>
                                                    <th style="vertical-align: middle;text-align:center;">Dept</th>
                                                    <th style="vertical-align: middle;text-align:center;">Total MP</th>
                                                    <!-- <th style="vertical-align: middle;text-align:center;">Quota STD</th> -->
                                                    <th style="vertical-align: middle;text-align:center;">Quota OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Budget OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Actual OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Act vs Budget (%)</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 1;
                                            foreach ($quota_usage_dept as $usage) { ?>
                                                <tr style="text-align:center;">
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $usage->KD_DEPT; ?></td>
                                                    <td><?php echo $usage->KRY; ?></td>
                                                    <!-- <td><?php echo number_format($usage->QUOTA_STD, 2, ',', '.'); ?></td> -->
                                                    <td><?php echo number_format($usage->QUOTAPLAN + $usage->QUOTAPLAN1, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->INT_BUDGET_QUOTA, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->TERPAKAIPLAN + $usage->TERPAKAIPLAN1, 2, ',', '.'); ?></td>
                                                    <?php
                                                    if ($usage->INT_BUDGET_QUOTA == 0 || $usage->INT_BUDGET_QUOTA == NULL) {
                                                        $act_vs_budget_dept = ((($usage->TERPAKAIPLAN + $usage->TERPAKAIPLAN1) / 100) * 100) + 100;
                                                    } else {
                                                        $act_vs_budget_dept = (($usage->TERPAKAIPLAN + $usage->TERPAKAIPLAN1) / $usage->INT_BUDGET_QUOTA) * 100;
                                                    }

                                                    $style = '';
                                                    if ($act_vs_budget_dept <= 90) {
                                                        $style = 'style="background-color: #55D785; color:white;"';
                                                    } else if ($act_vs_budget_dept > 90 && $act_vs_budget_dept <= 100) {
                                                        $style = 'style="background-color: orange; color:white;"';
                                                    } else if ($act_vs_budget_dept > 100) {
                                                        $style = 'style="background-color: #FE2D45; color:white;"';
                                                    }
                                                    ?>
                                                    <td <?php echo $style; ?>><?php echo number_format($act_vs_budget_dept, 2, ',', '.') . ' %'; ?></td>
                                                </tr>
                                            <?php $no++;
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>REMINDER APPROVE OVERTIME - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Dept / Section</strong></td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_gm/' . $period . '/' . trim($row->CHR_DEPT) . '/' . trim($section)); ?>" <?php
                                                                                                                                                                                                    if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_gm/' . $period . '/' . trim($dept) . '/' . trim($row->KODE)); ?>" <?php
                                                                                                                                                                                            if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="50%">

                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                            </table>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">No SPKL</th>
                                        <th style="text-align:center;">OT Description</th>
                                        <th style="text-align:center;">Total MP</th>
                                        <th style="text-align:center;">Plan OT (H)</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_approve as $isi) {
                                        if ($isi->CEK_KADEP == 1 && $isi->CEK_GM == 0) {
                                            $color = 'background:#E63F53;color:#fff;';
                                            $display = 'enabled';
                                        }
                                        if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                            $color = '';
                                            $display = 'disabled';
                                        }

                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";

                                        echo "<td style='$color'>$isi->NO_SEQUENCE</td>";
                                        if (strlen($isi->ALASAN) > 80) {
                                            echo "<td>" . substr($isi->ALASAN, 0, 80) . " ...</td>";
                                        } else {
                                            echo "<td>" . $isi->ALASAN . "</td>";
                                        }
                                        echo "<td align='center'><strong>$isi->TOT_MP</strong></td>";
                                        echo "<td align='center'><strong>" . number_format($isi->RENC_DURASI_OV_TIME, 2, ',', '.') . "</strong></td>";
                                    ?>
                                        <td align='center'>
                                            <?php
                                            if ($isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#E63F53;width:25px;height:25px;color:white;'></button> : Not Yet Approved
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
                $array_qr = 0;
                $id_qrcode[$array_qr] = 0;
                foreach ($data as $isi) {
                    if ($id_qrcode[$array_qr] != $isi->NO_SEQUENCE) {
                        $id_qrcode[$array_qr] = $isi->NO_SEQUENCE;
                ?>

                        <div class="modal fade" id="modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Overtime No : <?php echo $isi->NO_SEQUENCE ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('aorta/overtime_c/approve_form_overtime_by_gm', 'class="form-horizontal"'); ?>

                                            <input name="NO_SEQUENCE" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->NO_SEQUENCE ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_PERIOD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                                            <input name="CHR_SECTION" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">

                                            <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                                <table id="dataTables12" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Date</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Username</th>
                                                            <th rowspan="2" style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Sub Section</th>

                                                            <th style="vertical-align: middle;text-align:center;" colspan="4">Quota (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Planning (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Realization (H)</th>

                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC Name</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Std</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Plan</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Real</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Saldo</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Start</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Start</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                        </tr>

                                                    </thead>
                                                    <tbody id="data_detail<?php echo $isi->NO_SEQUENCE ?>">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <?php if ($isi->CEK_GM == 0) { ?>
                                                    <button type="submit" value=1 name="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve This Quota Request" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                <?php } else { ?>
                                                    <button type="submit" value=0 name="submit" class="btn btn-danger" data-placement="left" data-toggle="tooltip" title="Unapprove This Quota Request" onclick="return confirm('Are you sure want to Unapprove this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-down"></i> Unapprove</button>
                                                <?php } ?>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                        $array_qr++;
                    }
                    $id_qrcode[$array_qr] = 0;
                }
                ?>

                <div class="modal fade" id="modalQuota" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header  bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Quota Usage per Dept</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                        <table id="dataTables12" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;text-align:center;">No</th>
                                                    <th style="vertical-align: middle;text-align:center;">Dept</th>
                                                    <th style="vertical-align: middle;text-align:center;">Total MP</th>
                                                    <!-- <th style="vertical-align: middle;text-align:center;">Quota STD</th> -->
                                                    <th style="vertical-align: middle;text-align:center;">Quota OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Budget OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Actual OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Act vs Budget (%)</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 1;
                                            foreach ($quota_usage_dept as $usage) { ?>
                                                <tr style="text-align:center;">
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $usage->KD_DEPT; ?></td>
                                                    <td><?php echo $usage->KRY; ?></td>
                                                    <!-- <td><?php echo number_format($usage->QUOTA_STD, 2, ',', '.'); ?></td> -->
                                                    <td><?php echo number_format($usage->QUOTAPLAN + $usage->QUOTAPLAN1, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->INT_BUDGET_QUOTA, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->TERPAKAIPLAN + $usage->TERPAKAIPLAN1, 2, ',', '.'); ?></td>
                                                    <?php
                                                    if ($usage->INT_BUDGET_QUOTA == 0 || $usage->INT_BUDGET_QUOTA == NULL) {
                                                        $act_vs_budget_dept = ((($usage->TERPAKAIPLAN + $usage->TERPAKAIPLAN1) / 100) * 100) + 100;
                                                    } else {
                                                        $act_vs_budget_dept = (($usage->TERPAKAIPLAN + $usage->TERPAKAIPLAN1) / $usage->INT_BUDGET_QUOTA) * 100;
                                                    }

                                                    $style = '';
                                                    if ($act_vs_budget_dept <= 90) {
                                                        $style = 'style="background-color: #55D785; color:white;"';
                                                    } else if ($act_vs_budget_dept > 90 && $act_vs_budget_dept <= 100) {
                                                        $style = 'style="background-color: orange; color:white;"';
                                                    } else if ($act_vs_budget_dept > 100) {
                                                        $style = 'style="background-color: #FE2D45; color:white;"';
                                                    }
                                                    ?>
                                                    <td <?php echo $style; ?>><?php echo number_format($act_vs_budget_dept, 2, ',', '.') . ' %'; ?></td>
                                                </tr>
                                            <?php $no++;
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY THIS PERIODE - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='325px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_section/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>GROUP <?php echo $group; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div style="overflow:auto">
                            <table class="table table-condensed table-hover display" cellspacing="0" style="font-size: 9px;">
                                <thead>
                                    <tr>
                                        <td colspan='3' align='center' style="font-weight: bold;">Summary This Periode</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total MP</td>
                                        <td>:</td>
                                        <td><strong> <?php if ($detail_quota_group) {
                                                            echo $detail_quota_group->KRY;
                                                        } else {
                                                            echo 0;
                                                        } ?> MP</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Quota STD</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->QUOTA_STD, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Quota Plan</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->QUOTAPLAN, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Actual OT</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->TERPAKAIPLAN, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Saldo Quota</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->SISAPLAN, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg OT/MP</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format(($detail_quota_group->TERPAKAIPLAN / $detail_quota_group->KRY), 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg Quota (Est 22 WD)</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->AVG_QUOTA, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H/Day</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg OT (Est 22 WD)</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->AVG_OT, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H/Day</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg Saldo (Est 22 WD)</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->AVG_SISA, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H/Day</strong></td>
                                    </tr>
                                    <tr style="background-color: whitesmoke;">
                                        <td>Budget Quota</td>
                                        <td>:</td>
                                        <td><strong><?php echo number_format($detail_quota_group->INT_BUDGET_QUOTA, 2, ',', '.'); ?> H</strong></td>
                                    </tr>
                                    <?php
                                    $act_vs_budget = ($detail_quota_group->TERPAKAIPLAN / $detail_quota_group->INT_BUDGET_QUOTA) * 100;
                                    $style_color = '';
                                    if ($act_vs_budget <= 90) {
                                        $style_color = 'background-color: #55D785; color:white;';
                                    } else if ($act_vs_budget > 90 && $act_vs_budget <= 100) {
                                        $style_color = 'background-color: orange; color:white;';
                                    } else if ($act_vs_budget > 100) {
                                        $style_color = 'background-color: #FE2D45;color:white;';
                                    }
                                    ?>
                                    <tr style="<?php echo $style_color; ?>">
                                        <td>Actual vs Budget (%)</td>
                                        <td>:</td>
                                        <td>
                                            <strong><?php echo number_format(($detail_quota_group->TERPAKAIPLAN / $detail_quota_group->INT_BUDGET_QUOTA) * 100, 2, ',', '.'); ?> %</strong>
                                            <a data-toggle="modal" data-target="#modalQuota" data-placement="left" data-toggle="tooltip" title="Quota Usage per Dept" class="label label-info"><span class="fa fa-search"></span></a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!--<iframe frameBorder="0" width='100%' height='250px' src="<?php //echo site_url("aorta/overtime_c/view_detail_ot_group/" . $period . "/" . $group);  
                                                                                        ?>"></iframe>-->
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL QUOTA THIS PERIODE - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='160px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month/" . substr($period, 0, 4) . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>-->
        <?php if ($this->session->userdata('NPK') == '0714' || $this->session->userdata('NPK') == '07xx') { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-bars"></i>
                            <span class="grid-title">DETAIL <strong>ACTUAL OT/MP</strong> PER MONTH - <strong>GROUP <?php echo $group; ?></strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <iframe frameBorder="0" width='100%' height='220px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_gm_ver2/" . $period . "/" . $group); ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title">DETAIL <strong>QUOTA OT</strong> PER MONTH - <strong>GROUP <?php echo $group; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='200px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_gm/" . $period . "/" . $group); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('NPK') == '0714' || $this->session->userdata('NPK') == '07xx') { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-bars"></i>
                            <span class="grid-title">DETAIL <strong>ACTUAL OT/MP</strong> PER MONTH - <strong>GROUP PROD</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <iframe frameBorder="0" width='100%' height='220px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_gm_ver2/" . $period . "/PROD"); ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-bars"></i>
                            <span class="grid-title">DETAIL <strong>QUOTA OT</strong> PER MONTH - <strong>GROUP PROD</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <iframe frameBorder="0" width='100%' height='200px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_gm/" . $period . "/PROD"); ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-bars"></i>
                            <span class="grid-title">DETAIL <strong>QUOTA OT</strong> PER MONTH - <strong>PLANT</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <iframe frameBorder="0" width='100%' height='200px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_dir/" . $period); ?>"></iframe>
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 4
            }
        });

        //                                                    $('.dataTables_filter input').addClass('search-query');
        $('.dataTables_filter input').attr('placeholder', 'Search');
    });

    function get_data_detail(nospkl) {
        $("#data_detail").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('aorta/overtime_c/view_detail_overtime'); ?>",
            data: "nospkl=" + nospkl,
            success: function(data) {
                $("#data_detail" + nospkl).html(data);
            }
        });

    }
</script>