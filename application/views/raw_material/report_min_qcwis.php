<script type="text/javascript" src="<?php echo base_url('assets/script/newcanvas.js') ?>"></script>
<script type="text/javascript">
    window.onload = function() {
        var chart_min = new CanvasJS.Chart("chartMin", {
            animationEnabled: true,
            theme: "light",
            title: {
                text: "Data Min",
                fontFamily: "tahoma"
            },
            legend: {
                horizontalAlign: "center",
                verticalAlign: "bottom",
                fontSize: 12
            },
            axisY: {
                title: "Data Ukur",
                includeZero: false,
                interval: 2.18,
                minimum: <?php echo $lsl_lim; ?>,
                maximum: <?php echo $usl_lim; ?>,
                gridThickness: 1,
                gridDashType: "dash",
                suffix: "<?php echo trim($uom); ?>",
                stripLines: [{
                    value: <?php echo $lsl; ?>,
                    lineThickness: 2,
                    showOnTop: true,
                    label: "Min SL = <?php echo $lsl; ?>",
                    labelFontColor: "#ed1e1a",
                    color: "#ed1e1a"
                }]
            },
            axisX: {
                title: "Date",
                interval: 1,
                labelMaxWidth: 75,
                labelWrap: true
            },
            toolTip: {
                shared: true
            },
            data: [{
                type: "spline",
                name: "Min",
                showInLegend: true,
                legendText: "Data Min Hasil Ukur",
                dataPoints: [
                    <?php
                    foreach ($data_min as $isi) {
                        $date = trim($isi->CHR_CREATED_DATE);
                        $date = substr($date, 6, 2);
                        $uom =  trim($isi->CHR_UOM_SL);
                        $min = trim($isi->MIN_VAL);
                        $label = trim($date) . " - " . trim($isi->CHR_LOT_NOMOR);
                    ?> {
                            x: <?php echo trim($date); ?>,
                            y: <?php echo trim($isi->MIN_VAL); ?>
                        },
                    <?php
                    }
                    ?>
                ]
            }]
        });
        chart_min.render();
    }
</script>

<?php if ($data_min == false) { ?>
    <table width=100% id='filterdiagram'>
        <td> No data available in diagram</td>
    </table>
<?php } else { ?>
    <div id="chartMin" style="height: 400px; width: 100%;"></div>
<?php } ?>