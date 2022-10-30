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
                                showDetail(this);
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

    function showDetail(e) {
        $("#per-button").click();

        var perfect_date = null;
        if (e.category < 10) {
            perfect_date = '0' + e.category;
        } else {
            perfect_date = e.category;
        }

        var baseurl = $("#base_url").val();
        var work_center = $("#work_center").val();
        var date = $("#period").val() + '' + perfect_date;
        $("#modal-title").text('DETAIL LINE PERFORMANCE ' + work_center + ' ON ' + date);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: baseurl + "index.php/aorta/getPerDetail",
            cache: false,
            data: {
                date: date,
                work_center: work_center
            },
            beforeSend: function() {
                $('#loading-scan-center').show();
                $("#data-table").hide();
            },
            success: function(result, status, xhr) {
                setTimeout(function() {
                    $('#loading-scan-center').hide();
                    $("#data-table").html(result);
                    $("#data-table").show();
                }, 500);
            },
            error(jqXhr, textStatus, errorMessage) {
                console.log(jqXhr);
            }
        });
    }
</script>

<div id="chartPlanActualQuota" style="min-width: 400px; height: 300px; margin: 0 auto;"></div>


<button style='display:none;' id="per-button" data-toggle="modal" data-target="#perModal"></button>
<input type='hidden' id='dept' value='<?php echo $dept; ?>'>
<input type='hidden' id='section' value='<?php echo $section; ?>'>
<input type='hidden' id='period' value='<?php echo $period; ?>'>
<input type='hidden' id='base_url' value='<?php echo base_url(); ?>'>

<div class="modal modal-search fade" id="perModal" tabindex="-1" role="dialog" aria-labelledby="perModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class='modal-title' id="modal-title"></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class='table' id='data-table'>
                </div>
            </div>
        </div>
    </div>
</div>

<table id='datatables2' class="table table-condensed display" cellspacing="0" width="100%" style="font-size: 10px;padding-left:-0.5em;padding-right:-0.5em;">
    <thead>
        <tr>
            <!-- <td rowspan='2' style="font-weight: bold;vertical-align:center;text-align:center;">Quota</td> -->
            <td colspan='31' style="font-weight: bold;text-align:center">Date</td>
        </tr>
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

<span style="font-size:11px;font-style:italic;color:darkgrey;">Quota Plan = Status kuota sudah selesai (approved by GM/DIR) </span> <br>
<span style="font-size:11px;font-style:italic;color:darkgrey;">Actual OT  = Rencana Durasi Overtime </span>