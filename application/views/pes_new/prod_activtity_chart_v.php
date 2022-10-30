
        
        <script type="text/javascript">
                    var chart1;
                    $(document).ready(function () {
                    chart1 = new Highcharts.Chart({
                    chart: {
                            height: 250,
                            width:500,
                            renderTo: 'chartshift1',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: 'Shift 1'
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: ''
                            }
                            },
                            series: [
<?php
foreach ($data_summary_production_shift1 as $row_shift1) {
    ?>
                                {
                                name: '<?php echo $row_shift1->DESKRIPSI; ?>',
                                        data: [
    <?php
    echo (int)$row_shift1->DATE_1 . ',' . (int)$row_shift1->DATE_2 . ',' . (int)$row_shift1->DATE_3 . ',' . (int)$row_shift1->DATE_4 . ',' . (int)$row_shift1->DATE_5 . ',' . (int)$row_shift1->DATE_6 . ',' . (int)$row_shift1->DATE_7 . ',' . (int)$row_shift1->DATE_8 . ',' . (int)$row_shift1->DATE_9
    . ',' . (int)$row_shift1->DATE_10 . ',' . (int)$row_shift1->DATE_11 . ',' . (int)$row_shift1->DATE_12 . ',' . (int)$row_shift1->DATE_13 . ',' . (int)$row_shift1->DATE_14 . ',' . (int)$row_shift1->DATE_15 . ',' . (int)$row_shift1->DATE_16 . ',' . (int)$row_shift1->DATE_17
    . ',' . (int)$row_shift1->DATE_18 . ',' . (int)$row_shift1->DATE_19 . ',' . (int)$row_shift1->DATE_20 . ',' . (int)$row_shift1->DATE_21 . ',' . (int)$row_shift1->DATE_22 . ',' . (int)$row_shift1->DATE_23 . ',' . (int)$row_shift1->DATE_24 . ',' . (int)$row_shift1->DATE_25
    . ',' . (int)$row_shift1->DATE_26 . ',' . (int)$row_shift1->DATE_27 . ',' . (int)$row_shift1->DATE_28 . ',' . (int)$row_shift1->DATE_29 . ',' . (int)$row_shift1->DATE_30 . ',' . (int)$row_shift1->DATE_31;
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

                    <script type="text/javascript">
                    var chart2;
                    $(document).ready(function () {
                    chart2 = new Highcharts.Chart({
                    chart: {
                            height: 250,
                            width:500,
                            renderTo: 'chartshift2',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: 'Shift 2'
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: ''
                            }
                            },
                            series: [
<?php
foreach ($data_summary_production_shift2 as $row_shift2) {
    ?>
                                {
                                name: '<?php echo $row_shift2->DESKRIPSI; ?>',
                                        data: [
    <?php
    echo $row_shift2->DATE_1 . ',' . $row_shift2->DATE_2 . ',' . $row_shift2->DATE_3 . ',' . $row_shift2->DATE_4 . ',' . $row_shift2->DATE_5 . ',' . $row_shift2->DATE_6 . ',' . $row_shift2->DATE_7 . ',' . $row_shift2->DATE_8 . ',' . $row_shift2->DATE_9
    . ',' . $row_shift2->DATE_10 . ',' . $row_shift2->DATE_11 . ',' . $row_shift2->DATE_12 . ',' . $row_shift2->DATE_13 . ',' . $row_shift2->DATE_14 . ',' . $row_shift2->DATE_15 . ',' . $row_shift2->DATE_16 . ',' . $row_shift2->DATE_17
    . ',' . $row_shift2->DATE_18 . ',' . $row_shift2->DATE_19 . ',' . $row_shift2->DATE_20 . ',' . $row_shift2->DATE_21 . ',' . $row_shift2->DATE_22 . ',' . $row_shift2->DATE_23 . ',' . $row_shift2->DATE_24 . ',' . $row_shift2->DATE_25
    . ',' . $row_shift2->DATE_26 . ',' . $row_shift2->DATE_27 . ',' . $row_shift2->DATE_28 . ',' . $row_shift2->DATE_29 . ',' . $row_shift2->DATE_30 . ',' . $row_shift2->DATE_31;
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

                    <script type="text/javascript">
                    var chart3;
                    $(document).ready(function () {
                    chart3 = new Highcharts.Chart({
                    chart: {
                            height: 250,
                            width:500,
                            renderTo: 'chartshift3',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: 'Shift 3'
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: ''
                            }
                            },
                            series: [
<?php
foreach ($data_summary_production_shift3 as $row_shift3) {
    ?>
                                {
                                name: '<?php echo $row_shift3->DESKRIPSI; ?>',
                                        data: [
    <?php
    echo (int)$row_shift3->DATE_1 . ',' . (int)$row_shift3->DATE_2 . ',' . (int)$row_shift3->DATE_3 . ',' . (int)$row_shift3->DATE_4 . ',' . (int)$row_shift3->DATE_5 . ',' . (int)$row_shift3->DATE_6 . ',' . (int)$row_shift3->DATE_7 . ',' . (int)$row_shift3->DATE_8 . ',' . (int)$row_shift3->DATE_9
    . ',' . (int)$row_shift3->DATE_10 . ',' . (int)$row_shift3->DATE_11 . ',' . (int)$row_shift3->DATE_12 . ',' . (int)$row_shift3->DATE_13 . ',' . (int)$row_shift3->DATE_14 . ',' . (int)$row_shift3->DATE_15 . ',' . (int)$row_shift3->DATE_16 . ',' . (int)$row_shift3->DATE_17
    . ',' . (int)$row_shift3->DATE_18 . ',' . (int)$row_shift3->DATE_19 . ',' . (int)$row_shift3->DATE_20 . ',' . (int)$row_shift3->DATE_21 . ',' . (int)$row_shift3->DATE_22 . ',' . (int)$row_shift3->DATE_23 . ',' . (int)$row_shift3->DATE_24 . ',' . (int)$row_shift3->DATE_25
    . ',' . (int)$row_shift3->DATE_26 . ',' . (int)$row_shift3->DATE_27 . ',' .(int) $row_shift3->DATE_28 . ',' . (int)$row_shift3->DATE_29 . ',' . (int)$row_shift3->DATE_30 . ',' . (int)$row_shift3->DATE_31;
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

<script type="text/javascript">
                    var chart4;
                    $(document).ready(function () {
                    chart4 = new Highcharts.Chart({
                    chart: {
                            height: 250,
                            width:500,
                            renderTo: 'chartshift4',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: 'Shift 4'
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: ''
                            }
                            },
                            series: [
<?php
foreach ($data_summary_production_shift4 as $row_shift4) {
    ?>
                                {
                                name: '<?php echo $row_shift4->DESKRIPSI; ?>',
                                        data: [
    <?php
    echo $row_shift4->DATE_1 . ',' . $row_shift4->DATE_2 . ',' . $row_shift4->DATE_3 . ',' . $row_shift4->DATE_4 . ',' . $row_shift4->DATE_5 . ',' . $row_shift4->DATE_6 . ',' . $row_shift4->DATE_7 . ',' . $row_shift4->DATE_8 . ',' . $row_shift4->DATE_9
    . ',' . $row_shift4->DATE_10 . ',' . $row_shift4->DATE_11 . ',' . $row_shift4->DATE_12 . ',' . $row_shift4->DATE_13 . ',' . $row_shift4->DATE_14 . ',' . $row_shift4->DATE_15 . ',' . $row_shift4->DATE_16 . ',' . $row_shift4->DATE_17
    . ',' . $row_shift4->DATE_18 . ',' . $row_shift4->DATE_19 . ',' . $row_shift4->DATE_20 . ',' . $row_shift4->DATE_21 . ',' . $row_shift4->DATE_22 . ',' . $row_shift4->DATE_23 . ',' . $row_shift4->DATE_24 . ',' . $row_shift4->DATE_25
    . ',' . $row_shift4->DATE_26 . ',' . $row_shift4->DATE_27 . ',' . $row_shift4->DATE_28 . ',' . $row_shift4->DATE_29 . ',' . $row_shift4->DATE_30 . ',' . $row_shift4->DATE_31;
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
                    
                    <script type="text/javascript">
                    var chart1;
                    $(document).ready(function () {
                    chart1 = new Highcharts.Chart({
                    chart: {
                            height: 250,
                            width:500,
                            renderTo: 'chartshift1',
                            type: 'line',
                            plotBorderWidth: 1
                    },
                            credits: {
                            enabled: false
                            },
                            legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
                            tooltip: {
                            split: true,
                                    valueSuffix: ''
                            },
                            title: {
                            text: 'Shift 1'
                            },
                            xAxis: {
                            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21',
                                    '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
                            },
                            yAxis: {
                            title: {
                            text: ''
                            }
                            },
                            series: [
<?php
foreach ($data_summary_production_shift1 as $row_shift1) {
    ?>
                                {
                                name: '<?php echo $row_shift1->DESKRIPSI; ?>',
                                        data: [
    <?php
    echo (int)$row_shift1->DATE_1 . ',' . (int)$row_shift1->DATE_2 . ',' . (int)$row_shift1->DATE_3 . ',' . (int)$row_shift1->DATE_4 . ',' . (int)$row_shift1->DATE_5 . ',' . (int)$row_shift1->DATE_6 . ',' . (int)$row_shift1->DATE_7 . ',' . (int)$row_shift1->DATE_8 . ',' . (int)$row_shift1->DATE_9
    . ',' . (int)$row_shift1->DATE_10 . ',' . (int)$row_shift1->DATE_11 . ',' . (int)$row_shift1->DATE_12 . ',' . (int)$row_shift1->DATE_13 . ',' . (int)$row_shift1->DATE_14 . ',' . (int)$row_shift1->DATE_15 . ',' . (int)$row_shift1->DATE_16 . ',' . (int)$row_shift1->DATE_17
    . ',' . (int)$row_shift1->DATE_18 . ',' . (int)$row_shift1->DATE_19 . ',' . (int)$row_shift1->DATE_20 . ',' . (int)$row_shift1->DATE_21 . ',' . (int)$row_shift1->DATE_22 . ',' . (int)$row_shift1->DATE_23 . ',' . (int)$row_shift1->DATE_24 . ',' . (int)$row_shift1->DATE_25
    . ',' . (int)$row_shift1->DATE_26 . ',' . (int)$row_shift1->DATE_27 . ',' . (int)$row_shift1->DATE_28 . ',' . (int)$row_shift1->DATE_29 . ',' . (int)$row_shift1->DATE_30 . ',' . (int)$row_shift1->DATE_31;
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

 <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->
        <div class="row" >
            <div class="col-lg-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>SUMMARY CHART PRODUCTIVITY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                        <div class="grid-body" >
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                <?php if($data_summary_production_shift1 == 0){ ?>
                                        <td style="height: 250px; width: 50%;text-align:center;vertical-align: middle;border: 1px solid #C4C1BB;"><span style="font-size:20pt;color:#E0DEDB;">NO DATA IN SHIFT 1</span></td>
                                    <?php }else{ ?>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="chartshift1" style="height: 250px; width: 100%;"></div></td>
                                    <?php } ?>
                                    <?php if($data_summary_production_shift2 == 0){ ?>
                                        <td style="height: 250px; width: 50%;text-align:center;vertical-align: middle;border: 1px solid #C4C1BB;"><span style="font-size:20pt;color:#E0DEDB;">NO DATA IN SHIFT 2</span></td>
                                    <?php }else{ ?>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="chartshift2" style="height: 250px; width: 100%;"></div></td>
                                    <?php } ?>
                                <tr>
                                <tr>
                                    <?php if($data_summary_production_shift3 == 0){ ?>
                                        <td style="height: 250px; width: 50%;text-align:center;vertical-align: middle;border: 1px solid #C4C1BB;"><span style="font-size:20pt;color:#E0DEDB;">NO DATA IN SHIFT 3</span></td>
                                    <?php }else{ ?>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="chartshift3" style="height: 250px; width: 100%;"></div></td>
                                    <?php } ?>
                                    <?php if($data_summary_production_shift4 == 0){ ?>
                                        <td style="height: 250px; width: 50%;text-align:center;vertical-align: middle;border: 1px solid #C4C1BB;"><span style="font-size:20pt;color:#E0DEDB;">NO DATA IN SHIFT 4</span></td>
                                    <?php }else{ ?>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="chartshift4" style="height: 250px; width: 100%;"></div></td>
                                    <?php } ?>
                                <tr>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->