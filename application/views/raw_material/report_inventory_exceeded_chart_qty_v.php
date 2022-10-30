<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>


<script type="text/javascript">
            window.onload = function () {
            var chart_amount = new CanvasJS.Chart("chartContainer_amount",
            {
            animationEnabled: true,
                    theme: "theme1",
                    title: {
                    fontColor: "white",
                            text: "Negative"},
                    axisY: {

                    title: "Amount",
                            gridThickness: 1
                    },
                    dataPointMaxWidth: 80,
                    data: [
<?php
$row = 1;
foreach ($data_summary_inventory_by_prod as $isi) {
    ?>
    <?php if ($row != $total_row) { ?>

        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
        } else {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
        }
        $row++;
        ?>

    <?php } else { ?>
        <?php
        if ($isi->DEPT == 'PR1') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR2') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR3') {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else if ($isi->DEPT == 'PR4') {
            echo '{type: "stackedColumn", 
                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        } else {
            echo '{type: "stackedColumn", 

                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:' . $isi->AMOUNT . ',label:' . '"' . $isi->CLASSNAME . '"' . '}'
            . ']},';
            echo '{type: "stackedColumn", 

                                                        indexLabel:' . '"' . '#total' . '"' . ',
                                                        legendText:' . '"' . $isi->CLASSNAME . '"' . ',
                                                        dataPoints: [' .
            '{y:0,label:' . '"' . 'PR1' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR2' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR3' . '"' . '},' .
            '{y:0,label:' . '"' . 'PR4' . '"' . '},' .
            '{y:0,label:' . '"' . 'PPC' . '"' . '}'
            . ']}';
        }
        ?>
    <?php } ?>

<?php } ?>
                    ],
                    legend: {
                    cursor: "pointer",
                            itemclick: function (e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                            } else {
                            e.dataSeries.visible = true;
                            }
                            chart_quality.render();
                            }
                    }
            });
                    chart_amount.render();
            }
</script>

<div id="chartContainer_amount" ></div>
