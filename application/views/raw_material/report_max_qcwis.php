<script type="text/javascript" src="<?php echo base_url('assets/script/newcanvas.js') ?>"></script>
<script type="text/javascript">
    window.onload = function() {
        var chart_max = new CanvasJS.Chart("chartMax", {
            animationEnabled: true,
            theme: "light",
            title: {
                text: "Data Max",
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
                    value: <?php echo $usl; ?>,
                    lineThickness: 2,
                    showOnTop: true,
                    label: "Max SL = <?php echo $usl; ?>",
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
                name: "Max",
                showInLegend: true,
                legendText: "Data Max Hasil Ukur",
                dataPoints: [
                    <?php
                    foreach ($data_max as $isi) {
                        $date = trim($isi->CHR_CREATED_DATE);
                        $date = substr($date, 6, 2);
                        $uom =  trim($isi->CHR_UOM_SL);
                        $max = trim($isi->MAX_VAL);
                        $label = trim($date) . " - " . trim($isi->CHR_LOT_NOMOR);
                    ?> {
                            x: <?php echo trim($date); ?>,
                            y: <?php echo trim($isi->MAX_VAL); ?>
                        },
                    <?php
                    }
                    ?>
                ]
            }]
        });
        chart_max.render();
    }
</script>

<?php if ($data_max == false) { ?>
    <table width=100% id='filterdiagram'>
        <td> No data available in diagram</td>
    </table>
<?php } else { ?>
    <div id="chartMax" style="height: 400px; width: 100%;"></div>
<?php } ?>