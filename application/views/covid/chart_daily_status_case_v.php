<script type="text/javascript">
    var chart1;
    $(document).ready(function () {
    chart1 = new Highcharts.Chart({
    chart: {
    renderTo: 'container',
            type: 'spline',
            plotBorderWidth: 1
    },
            credits: {
             enabled: false
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            title: {
            text: ''
            },
            xAxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
            },
            yAxis: {
                tickInterval: 1,
                title: {
                    text: 'Case'
                },
                min:0
            },
            series: [
<?php
    foreach ($data_daily_status_case as $row) {
        ?>
                                    {
                                    name: '<?php echo $row->status_covid; ?>',
                                            data: [
        <?php
        echo $row->DT_01 . ',' . $row->DT_02 . ',' . $row->DT_03 . ',' . $row->DT_04 . ',' . $row->DT_05 . ',' . $row->DT_06 . ',' . $row->DT_07 . ',' . $row->DT_08 . ',' . $row->DT_09
        . ',' . $row->DT_10 . ',' . $row->DT_11 . ',' . $row->DT_12 . ',' . $row->DT_13 . ',' . $row->DT_14 . ',' . $row->DT_15 . ',' . $row->DT_16 . ',' . $row->DT_17
        . ',' . $row->DT_18 . ',' . $row->DT_19 . ',' . $row->DT_20 . ',' . $row->DT_21 . ',' . $row->DT_22 . ',' . $row->DT_23 . ',' . $row->DT_24 . ',' . $row->DT_25
        . ',' . $row->DT_26 . ',' . $row->DT_27 . ',' . $row->DT_28 . ',' . $row->DT_29 . ',' . $row->DT_30 . ',' . $row->DT_31;
        ?>
                                            ]
                                    },
        <?php
    }
?>
                            ]
                    });
                    });
                </script>

<?php if ($data_daily_status_case == false) { ?>
    <table width=100% ><td> No data available in diagram</td></table>
<?php } else { ?>
    <div id="container" style="height: 300px; width: 100%;"></div>
<?php } ?>
