<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>

<!-- GET DATA TO CHART -->
<?php
$row_plan_target = count($summary_ot_amount);
$row_plan = 1;
$amount_plan = "";
foreach ($summary_ot_amount as $isi) {
    if ($row_plan == $row_plan_target) {
        $amount_plan .= '{label: "' . $isi->KD_DEPT . '", y:' . $isi->AMO_QUOTA_STD . ', indexLabel:"' . round(number_format($isi->AMO_QUOTA_STD / 1000, 0, ",", "."),2) . '"}';
        $row_plan++;
    } else {
        $amount_plan .= '{label: "' . $isi->KD_DEPT . '", y:' . $isi->AMO_QUOTA_STD . ' , indexLabel:"' . round(number_format($isi->AMO_QUOTA_STD / 1000, 0, ",", "."),2) . '"},';
        $row_plan++;
    }
}

$row_plan = 1;
$amount_plafond = "";
foreach ($summary_ot_amount as $isi) {
    if ($row_plan == $row_plan_target) {
        $amount_plafond .= '{label: "' . $isi->KD_DEPT . '", y:' . $isi->AMO_PLAFOND . ', indexLabel:"' . round(number_format($isi->AMO_PLAFOND / 1000, 0, ",", "."),2) . '"}';
        $row_plan++;
    } else {
        $amount_plafond .= '{label: "' . $isi->KD_DEPT . '", y:' . $isi->AMO_PLAFOND . ' , indexLabel:"' . round(number_format($isi->AMO_PLAFOND / 1000, 0, ",", "."),2) . '"},';
        $row_plan++;
    }
}

$row_plan = 1;
$amount_salary = "";
foreach ($summary_ot_amount as $isi) {
    if ($row_plan == $row_plan_target) {
        $amount_salary .= '{label: "' . $isi->KD_DEPT . '", y:' . $isi->TOT_AMOUNT_OVERTIME . ', indexLabel:"' . round(number_format($isi->TOT_AMOUNT_OVERTIME / 1000, 0, ",", "."),2) . '"}';
        $row_plan++;
    } else {
        $amount_salary .= '{label: "' . $isi->KD_DEPT . '", y:' . $isi->TOT_AMOUNT_OVERTIME . ', indexLabel:"' . round(number_format($isi->TOT_AMOUNT_OVERTIME / 1000, 0, ",", "."),2) . '"},';
        $row_plan++;
    }
}
?>
<script type="text/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer1",
                {
                    theme: "theme2",
                    animationEnabled: true,
                    title: {
                        text: "",
                        fontSize: 2
                    },
                    toolTip: {
                        shared: true
                    },
                    axisY: {
                        title: "Amount",
                        interval: 50000000,
                        gridThickness:0.2,
                        fontSize: 2
                    },
                    axisY2: {
                        title: "Amount",
                        interval: 50000000,
                        fontSize: 2
                    },
                    data: [
                        {
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "vertical",
                            indexLabelFontSize: 13,
                            indexLabelFontColor: "black",
                            type: "column",
                            name: "PLAN (Rp)",
                            legendText: "PLAN",
                            showInLegend: true,
                            dataPoints: [
<?php
echo $amount_plan;
?>
                            ]
                        },
                        {
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "vertical",
                            indexLabelFontSize: 13,
                            indexLabelFontColor: "black",
                            type: "column",
                            name: "PLAFOND (Rp)",
                            legendText: "PLAFOND",
                            //axisYType: "secondary",
                            showInLegend: true,
                            dataPoints: [
<?php
echo $amount_plafond;
?>
                            ]
                        },
                        {
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "vertical",
                            indexLabelFontSize: 13,
                            indexLabelFontColor: "black",
                            type: "column",
                            name: "REALIZATION (Rp)",
                            legendText: "REALISASI",
                            //axisYType: "secondary",
                            showInLegend: true,
                            dataPoints: [
<?php
echo $amount_salary;
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
    };
</script>

    <div class="grid-body">
        <?php if (count($summary_ot_amount) == 0) {  ?>
            <table  id='filterdiagram' ><td> No data available in diagram</td></table>
        <?php } else { ?>
            <div id="chartContainer1" ></div>
        <?php } ?>
    </div>




