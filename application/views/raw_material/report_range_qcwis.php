<script type="text/javascript" src="<?php echo base_url('assets/script/newcanvas.js') ?>"></script>
<script type="text/javascript">
    window.onload = function() {
        var chart_range = new CanvasJS.Chart("chartRange", {
            animationEnabled: true,
            theme: "light",
            title: {
                text: "Data Range",
                fontFamily: "tahoma"
            },
            legend: {
                horizontalAlign: "center",
                verticalAlign: "bottom",
                fontSize: 12
            },
            axisY: {
                title: "Range",
                includeZero: false,
                interval: 0.18,
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
                    },
                    {
                        value: <?php echo $usl; ?>,
                        lineThickness: 2,
                        showOnTop: true,
                        label: "Max SL = <?php echo $usl; ?>",
                        labelFontColor: "#ed1e1a",
                        color: "#ed1e1a"
                    }
                ]
            },
            axisX: {
                title: "Date",
                labelMaxWidth: 75,
                labelWrap: true
            },
            toolTip: {
                shared: true
            },
            data: [{
                markerType: "triangle",
                type: "error",
                whiskerLength: 15,
                whiskerThickness: 4,
                name: "Range ",
                showInLegend: true,
                legendText: "Data Range Hasil Ukur",
                toolTipContent: "<span style=\"color:#C0504E\">{name}</span> : {y[0]} <?php echo trim($uom); ?> - {y[1]} <?php echo trim($uom); ?>",
                dataPoints: [
                    <?php
                    foreach ($data_range as $isi) {
                        $date = trim($isi->CHR_CREATED_DATE);
                        $date = substr($date, 6, 2);
                        $uom =  trim($isi->CHR_UOM_SL);
                        $min = trim($isi->MIN_VAL);
                        $max = trim($isi->MAX_VAL);
                        $label = trim($date) . " - " . trim($isi->CHR_LOT_NOMOR);
                    ?> {
                            y: [<?php echo trim($min); ?>, <?php echo trim($max); ?>],
                            label: "<?php echo $label; ?>"
                        },
                    <?php
                    }
                    ?>
                ]
            }]
        });
        chart_range.render();
    }
</script>

<?php if ($data_range == false) { ?>
    <table width=100% id='filterdiagram'>
        <td> No data available in diagram</td>
    </table>
<?php } else { ?>
    <div id="chartRange" style="height: 400px; width: 100%;"></div>
<?php } ?>