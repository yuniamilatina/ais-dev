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
                renderTo: 'chartPlanQuotaReq',
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
                    text: 'Hours'
                },
                labels: {
                    style: {
                        color: '#9E9E9E',
                        fontSize: '10px'
                    }
                }
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                            }
                        }
                    },
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

<div id="chartPlanQuotaReq" style="min-width: 400px; height: 300px; margin: 0 auto;"></div>

<button style='display:none;' id="per-button" data-toggle="modal" data-target="#perModal"></button>
<input type='hidden' id='dept' value='<?php echo $dept; ?>'>
<input type='hidden' id='section' value='<?php echo $section; ?>'>
<input type='hidden' id='period' value='<?php echo $period; ?>'>