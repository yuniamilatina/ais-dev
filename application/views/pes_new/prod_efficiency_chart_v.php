<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>

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
    window.onload = function() {

        var chart_efficiency = new CanvasJS.Chart("chartEfficiency", {

            animationEnabled: true,
            theme: "light",
            title: {
                text: ""
            },
            legend: {
                horizontalAlign: "center",
                verticalAlign: "bottom",
                fontSize: 12
            },
            axisY: {
                title: "Efficiency (%)",
                includeZero: false,
                gridThickness: 1,
                opacity: .4
            },
            axisX: {
                title: "Date",
                interval: 1,
                stripLines: [

                    <?php
                    for ($a = 0; $a < $x; $a++) {
                        if ($a == $x - 1) {
                    ?> {
                                startValue: <?php echo $datesunday[$a] - 1; ?>,
                                endValue: <?php echo $datesunday[$a]; ?>,
                                color: "#FC3322",
                                opacity: .2
                            }
                        <?php } else { ?> {
                                startValue: <?php echo $datesunday[$a] - 1; ?>,
                                endValue: <?php echo $datesunday[$a]; ?>,
                                color: "#FC3322",
                                opacity: .2
                            },
                    <?php
                        }
                    }
                    ?>

                ],
            },
            data: [{
                    type: "line",
                    showInLegend: true,
                    color: "#00AB55",
                    legendText: "Formula : (Work Time - Bridging) / Work Time * 100",
                    indexLabelPlacement: "outside",
                    indexLabelOrientation: "horizontal",
                    // fillOpacity: .3, 
                    dataPoints: [

                        <?php
                        foreach ($data_efficiency as $isi) {
                        ?>

                            {
                                x: 1,
                                y: <?php echo $isi->DATE_01; ?>
                            },
                            {
                                x: 2,
                                y: <?php echo $isi->DATE_02; ?>
                            },
                            {
                                x: 3,
                                y: <?php echo $isi->DATE_03; ?>
                            },
                            {
                                x: 4,
                                y: <?php echo $isi->DATE_04; ?>
                            },
                            {
                                x: 5,
                                y: <?php echo $isi->DATE_05; ?>
                            },
                            {
                                x: 6,
                                y: <?php echo $isi->DATE_06; ?>
                            },
                            {
                                x: 7,
                                y: <?php echo $isi->DATE_07; ?>
                            },
                            {
                                x: 8,
                                y: <?php echo $isi->DATE_08; ?>
                            },
                            {
                                x: 9,
                                y: <?php echo $isi->DATE_09; ?>
                            },
                            {
                                x: 10,
                                y: <?php echo $isi->DATE_10; ?>
                            },
                            {
                                x: 11,
                                y: <?php echo $isi->DATE_11; ?>
                            },
                            {
                                x: 12,
                                y: <?php echo $isi->DATE_12; ?>
                            },
                            {
                                x: 13,
                                y: <?php echo $isi->DATE_13; ?>
                            },
                            {
                                x: 14,
                                y: <?php echo $isi->DATE_14; ?>
                            },
                            {
                                x: 15,
                                y: <?php echo $isi->DATE_15; ?>
                            },
                            {
                                x: 16,
                                y: <?php echo $isi->DATE_16; ?>
                            },
                            {
                                x: 17,
                                y: <?php echo $isi->DATE_17; ?>
                            },
                            {
                                x: 18,
                                y: <?php echo $isi->DATE_18; ?>
                            },
                            {
                                x: 19,
                                y: <?php echo $isi->DATE_19; ?>
                            },
                            {
                                x: 20,
                                y: <?php echo $isi->DATE_20; ?>
                            },
                            {
                                x: 21,
                                y: <?php echo $isi->DATE_21; ?>
                            },
                            {
                                x: 22,
                                y: <?php echo $isi->DATE_22; ?>
                            },
                            {
                                x: 23,
                                y: <?php echo $isi->DATE_23; ?>
                            },
                            {
                                x: 24,
                                y: <?php echo $isi->DATE_24; ?>
                            },
                            {
                                x: 25,
                                y: <?php echo $isi->DATE_25; ?>
                            },
                            {
                                x: 26,
                                y: <?php echo $isi->DATE_26; ?>
                            },
                            {
                                x: 27,
                                y: <?php echo $isi->DATE_27; ?>
                            },
                            {
                                x: 28,
                                y: <?php echo $isi->DATE_28; ?>
                            },
                            {
                                x: 29,
                                y: <?php echo $isi->DATE_29; ?>
                            },
                            {
                                x: 30,
                                y: <?php echo $isi->DATE_30; ?>
                            },
                            {
                                x: 31,
                                y: <?php echo $isi->DATE_31; ?>
                            }

                        <?php
                        }
                        ?>
                    ]
                },
                {
                    type: "line",
                    showInLegend: true,
                    lineDashType: "dash",
                    lineThickness: 2,
                    color: "#831212",
                    markerType: "none",
                    legendText: "Trial Threshold",
                    indexLabelPlacement: "outside",
                    indexLabelOrientation: "horizontal",
                    dataPoints: [{
                            x: 1,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 2,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 3,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 4,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 5,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 6,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 7,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 8,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 9,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 10,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 11,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 12,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 13,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 14,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 15,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 16,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 17,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 18,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 19,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 20,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 21,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 22,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 23,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 24,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 25,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 26,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 27,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 28,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 29,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 30,
                            y: <?php echo $threshold_efficiency; ?>
                        },
                        {
                            x: 31,
                            y: <?php echo $threshold_efficiency; ?>
                        }
                    ]
                },
                {
                    type: "line",
                    showInLegend: true,
                    lineDashType: "dash",
                    lineThickness: 2,
                    color: "#000000",
                    markerType: "none",
                    legendText: "Average",
                    indexLabelPlacement: "outside",
                    indexLabelOrientation: "horizontal",
                    dataPoints: [{
                            x: 1,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 2,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 3,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 4,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 5,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 6,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 7,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 8,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 9,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 10,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 11,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 12,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 13,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 14,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 15,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 16,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 17,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 18,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 19,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 20,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 21,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 22,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 23,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 24,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 25,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 26,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 27,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 28,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 29,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 30,
                            y: <?php echo $threshold_average_efficiency; ?>
                        },
                        {
                            x: 31,
                            y: <?php echo $threshold_average_efficiency; ?>
                        }
                    ]
                }



            ]
        });
        chart_efficiency.render();

    }
</script>



<!-- <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>EFFICIENCY CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body"> -->

<?php if ($data_efficiency == false) { ?>
    <table width=100% id='filterdiagram'>
        <td> No data available in diagram</td>
    </table>
<?php } else { ?>
    <div id="chartEfficiency" style="height: 300px; width: 100%;"></div>
<?php } ?>

<!-- </div>
                </div>
            </div>
        </div> -->