<style type="text/css">
    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-left-width: 0.4em;
        border-left-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-left-width: 0.4em;
        border-left-color: #bce8f1;
}
</style>

<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'yymmdd'}).val();

    });
</script>

<script>     
    var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)))
        }
    , format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
        return c[p];
    })
    }
    return function (table, name) {
    if (!table.nodeType)
        table = document.getElementById(table)
    var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<script type="text/javascript">

    $(document).ready(function () {
        
    chart1 = new Highcharts.Chart({
        chart: {
            // zoomType: 'xy',
            height: 250,
            width:650,
            // type: 'column',
            renderTo: 'container_up',
            plotBorderWidth: 1
        },
        title: {
            text: 'Unit Parts'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category',
            crosshair: true
        },
        yAxis: {
             // type: 'logarithmic',
            max: 120,
            title: {
                text: ''
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [
                { 
                    from: 0,
                    to: 0,
                    color: '#FC4444',
                    label: {
                        text: '',
                        style: {
                            color: '#D3EEF7'
                        }
                    }
                },
                { 
                    from: 95,
                    to: 100,
                    color: '#87FF9D'
                }
            ]
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            get_detail(this);
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>',
            shared: true
        },
        series: [
            {
                name: 'Efficiency',
                type: 'column',
                colorByPoint: true,
                data: [
                        <?php
                            foreach ($data_eff_per_group_date_up as $isi) {
                                ?>
                                {
                                    name: "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                    y: <?php echo $isi->QTY; ?>
                                },
                            <?php }
                        ?>
                ]
            }
        ],
    });

    chart2 = new Highcharts.Chart({
        chart: {
            height: 250,
            width:650,
            type: 'column',
            renderTo: 'container_bp',
            plotBorderWidth: 1
        },
        title: {
            text: 'Body Parts'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
             // type: 'logarithmic',
             max: 120,
            title: {
                text: ''
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [
                { 
                    from: 0,
                    to: 0,
                    color: '#FC4444',
                    label: {
                        text: '',
                        style: {
                            color: '#D3EEF7'
                        }
                    }
                },
                { 
                    from: 95,
                    to: 100,
                    color: '#87FF9D'
                }
            ]
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            get_detail(this);
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
        },

        "series": [
            {
                "name": "Efficiency",
                "colorByPoint": true,
                "data": [
                        <?php
                            foreach ($data_eff_per_group_date_bp as $isi) {
                                ?>
                                {
                                    "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                    "y": <?php echo $isi->QTY; ?>
                                },
                            <?php }
                        ?>
                ]
            }
            
        ],
    });

    chart3 = new Highcharts.Chart({
        chart: {
            height: 250,
            width:650,
            type: 'column',
            renderTo: 'container_dl',
            plotBorderWidth: 1
        },
        title: {
            text: 'Door lock'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
             // type: 'logarithmic',
             max: 120,
            title: {
                text: ''
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [
                { 
                    from: 0,
                    to: 0,
                    color: '#FC4444',
                    label: {
                        text: '',
                        style: {
                            color: '#D3EEF7'
                        }
                    }
                },
                { 
                    from: 95,
                    to: 100,
                    color: '#87FF9D'
                }
            ]
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            get_detail(this);
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
        },

        "series": [
            {
                "name": "Efficiency",
                "colorByPoint": true,
                "data": [
                        <?php
                            foreach ($data_eff_per_group_date_dl as $isi) {
                                ?>
                                {
                                    "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                    "y": <?php echo $isi->QTY; ?>
                                },
                            <?php }
                        ?>
                ]
            }
            
        ],
    });

    chart4 = new Highcharts.Chart({
        chart: {
            height: 250,
            width:650,
            type: 'column',
            renderTo: 'container_dr',
            plotBorderWidth: 1
        },
        title: {
            text: 'Door Frame'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
             // type: 'logarithmic',
             max: 120,
            title: {
                text: ''
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [
                { 
                    from: 0,
                    to: 0,
                    color: '#FC4444',
                    label: {
                        text: '',
                        style: {
                            color: '#D3EEF7'
                        }
                    }
                },
                { 
                    from: 95,
                    to: 100,
                    color: '#87FF9D'
                }
        ]
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            get_detail(this);
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
        },

        "series": [
            {
                "name": "Efficiency",
                "colorByPoint": true,
                "data": [
                        <?php
                            foreach ($data_eff_per_group_date_dr as $isi) {
                                ?>
                                {
                                    "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                    "y": <?php echo $isi->QTY; ?>
                                },
                            <?php }
                        ?>
                ]
            }
            
        ],
    });

    chart5 = new Highcharts.Chart({
        chart: {
            height: 250,
            width:1320,
            type: 'column',
            renderTo: 'container_mg',
            plotBorderWidth: 1,
            scrollablePlotArea: {
                minWidth: 1320
            }
        },
        title: {
            text: 'Manufacture'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
             // type: 'logarithmic',
             max: 120,
            title: {
                text: ''
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [
                { 
                    from: 0,
                    to: 0,
                    color: '#FC4444',
                    label: {
                        text: '',
                        style: {
                            color: '#D3EEF7'
                        }
                    }
                },
                { 
                    from: 95,
                    to: 100,
                    color: '#87FF9D'
                }
            ]
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            get_detail(this);
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
        },

        "series": [
            {
                "name": "Efficiency",
                "colorByPoint": true,
                "data": [
                        <?php
                            foreach ($data_eff_per_group_date_mg as $isi) {
                                ?>
                                {
                                    "name": "<?php echo $isi->CHR_WORK_CENTER; ?>",
                                    "y": <?php echo $isi->QTY; ?>
                                },
                            <?php }
                        ?>
                ]
            }
            
        ],
    });

});

    function get_detail(e){

    $.ajax({
            async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('pes_new/report_prod_line_stop_c/get_data_by_work_center_and_date'); ?>",
                    data: "CHR_WORK_CENTER=" + e.name + "&CHR_DATE=" + '<?php echo $date ?>',
                    success: function (data) {
                        document.getElementById('modal1-trigger').click();

                        $("#comment-data").html(data.data);
                        $("#detail_chart2").html(data.data_chart);

                        document.getElementById('work-center').innerHTML=e.name;
                    },
                    error: function(request) {
                        alert(request.responseText);
                    }
            });
    }

</script>

<script type="text/javascript">

    $(document).ready(function () {
    
    chart1 = new Highcharts.Chart({
        chart: {
            height: 250,
            width:650,
            type: 'line',
            renderTo: 'container_detail_up',
            plotBorderWidth: 1
        },
        title: {
            text: 'Unit Parts'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
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
        legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },
        series: [
            <?php
    foreach ($data_eff_per_group_and_period_up as $isi) {
        ?>
                                    {
                                    name: '<?php echo $isi->CHR_WORK_CENTER; ?>',
                                    data: [
        <?php
        echo (int)$isi->DATE_1 . ',' . (int)$isi->DATE_2 . ',' . (int)$isi->DATE_3 . ',' . (int)$isi->DATE_4 . ',' . (int)$isi->DATE_5 . ',' . (int)$isi->DATE_6 . ',' . (int)$isi->DATE_7 . ',' . (int)$isi->DATE_8 . ',' . (int)$isi->DATE_9
        . ',' . (int)$isi->DATE_10 . ',' . (int)$isi->DATE_11 . ',' . (int)$isi->DATE_12 . ',' . (int)$isi->DATE_13 . ',' . (int)$isi->DATE_14 . ',' . (int)$isi->DATE_15 . ',' . (int)$isi->DATE_16 . ',' . (int)$isi->DATE_17
        . ',' . (int)$isi->DATE_18 . ',' . (int)$isi->DATE_19 . ',' . (int)$isi->DATE_20 . ',' . (int)$isi->DATE_21 . ',' . (int)$isi->DATE_22 . ',' . (int)$isi->DATE_23 . ',' . (int)$isi->DATE_24 . ',' . (int)$isi->DATE_25
        . ',' . (int)$isi->DATE_26 . ',' . (int)$isi->DATE_27 . ',' . (int)$isi->DATE_28 . ',' . (int)$isi->DATE_29 . ',' . (int)$isi->DATE_30 . ',' . (int)$isi->DATE_31;
        ?>
                                            ]
                                    },
        <?php
    }
    ?>
            ]
    });

    chart2 = new Highcharts.Chart({
        chart: {
            height: 250,
            width:650,
            type: 'line',
            renderTo: 'container_detail_bp',
            plotBorderWidth: 1
        },
        title: {
            text: 'Body Parts'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
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
        legend: {
                            borderColor: '#cccccc',
                                    borderWidth: 1,
                                    borderRadius: 3
                            },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },
        series: [
            <?php
    foreach ($data_eff_per_group_and_period_bp as $isi) {
        ?>
                                    {
                                    name: '<?php echo $isi->CHR_WORK_CENTER; ?>',
                                    data: [
        <?php
        echo (int)$isi->DATE_1 . ',' . (int)$isi->DATE_2 . ',' . (int)$isi->DATE_3 . ',' . (int)$isi->DATE_4 . ',' . (int)$isi->DATE_5 . ',' . (int)$isi->DATE_6 . ',' . (int)$isi->DATE_7 . ',' . (int)$isi->DATE_8 . ',' . (int)$isi->DATE_9
        . ',' . (int)$isi->DATE_10 . ',' . (int)$isi->DATE_11 . ',' . (int)$isi->DATE_12 . ',' . (int)$isi->DATE_13 . ',' . (int)$isi->DATE_14 . ',' . (int)$isi->DATE_15 . ',' . (int)$isi->DATE_16 . ',' . (int)$isi->DATE_17
        . ',' . (int)$isi->DATE_18 . ',' . (int)$isi->DATE_19 . ',' . (int)$isi->DATE_20 . ',' . (int)$isi->DATE_21 . ',' . (int)$isi->DATE_22 . ',' . (int)$isi->DATE_23 . ',' . (int)$isi->DATE_24 . ',' . (int)$isi->DATE_25
        . ',' . (int)$isi->DATE_26 . ',' . (int)$isi->DATE_27 . ',' . (int)$isi->DATE_28 . ',' . (int)$isi->DATE_29 . ',' . (int)$isi->DATE_30 . ',' . (int)$isi->DATE_31;
        ?>
                                            ]
                                    },
        <?php
    }
    ?>
            ]
    });

    chart3 = new Highcharts.Chart({
            chart: {
                height: 250,
                width:650,
                type: 'line',
                renderTo: 'container_detail_dl',
                plotBorderWidth: 1
            },
            title: {
                text: 'Door Lock'
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
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
        
            legend: {
                                borderColor: '#cccccc',
                                        borderWidth: 1,
                                        borderRadius: 3
                                },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            series: [
                <?php
        foreach ($data_eff_per_group_and_period_dl as $isi) {
            ?>
                                        {
                                        name: '<?php echo $isi->CHR_WORK_CENTER; ?>',
                                        data: [
            <?php
            echo (int)$isi->DATE_1 . ',' . (int)$isi->DATE_2 . ',' . (int)$isi->DATE_3 . ',' . (int)$isi->DATE_4 . ',' . (int)$isi->DATE_5 . ',' . (int)$isi->DATE_6 . ',' . (int)$isi->DATE_7 . ',' . (int)$isi->DATE_8 . ',' . (int)$isi->DATE_9
            . ',' . (int)$isi->DATE_10 . ',' . (int)$isi->DATE_11 . ',' . (int)$isi->DATE_12 . ',' . (int)$isi->DATE_13 . ',' . (int)$isi->DATE_14 . ',' . (int)$isi->DATE_15 . ',' . (int)$isi->DATE_16 . ',' . (int)$isi->DATE_17
            . ',' . (int)$isi->DATE_18 . ',' . (int)$isi->DATE_19 . ',' . (int)$isi->DATE_20 . ',' . (int)$isi->DATE_21 . ',' . (int)$isi->DATE_22 . ',' . (int)$isi->DATE_23 . ',' . (int)$isi->DATE_24 . ',' . (int)$isi->DATE_25
            . ',' . (int)$isi->DATE_26 . ',' . (int)$isi->DATE_27 . ',' . (int)$isi->DATE_28 . ',' . (int)$isi->DATE_29 . ',' . (int)$isi->DATE_30 . ',' . (int)$isi->DATE_31;
            ?>
                                                ]
                                        },
            <?php
        }
        ?>
                ]
        });


    chart4 = new Highcharts.Chart({
            chart: {
                height: 250,
                width:650,
                type: 'line',
                renderTo: 'container_detail_dr',
                plotBorderWidth: 1
            },
            title: {
                text: 'Door Frame'
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
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
            legend: {
                                borderColor: '#cccccc',
                                        borderWidth: 1,
                                        borderRadius: 3
                                },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            series: [
                <?php
        foreach ($data_eff_per_group_and_period_dr as $isi) {
            ?>
                                        {
                                        name: '<?php echo $isi->CHR_WORK_CENTER; ?>',
                                        data: [
            <?php
            echo (int)$isi->DATE_1 . ',' . (int)$isi->DATE_2 . ',' . (int)$isi->DATE_3 . ',' . (int)$isi->DATE_4 . ',' . (int)$isi->DATE_5 . ',' . (int)$isi->DATE_6 . ',' . (int)$isi->DATE_7 . ',' . (int)$isi->DATE_8 . ',' . (int)$isi->DATE_9
            . ',' . (int)$isi->DATE_10 . ',' . (int)$isi->DATE_11 . ',' . (int)$isi->DATE_12 . ',' . (int)$isi->DATE_13 . ',' . (int)$isi->DATE_14 . ',' . (int)$isi->DATE_15 . ',' . (int)$isi->DATE_16 . ',' . (int)$isi->DATE_17
            . ',' . (int)$isi->DATE_18 . ',' . (int)$isi->DATE_19 . ',' . (int)$isi->DATE_20 . ',' . (int)$isi->DATE_21 . ',' . (int)$isi->DATE_22 . ',' . (int)$isi->DATE_23 . ',' . (int)$isi->DATE_24 . ',' . (int)$isi->DATE_25
            . ',' . (int)$isi->DATE_26 . ',' . (int)$isi->DATE_27 . ',' . (int)$isi->DATE_28 . ',' . (int)$isi->DATE_29 . ',' . (int)$isi->DATE_30 . ',' . (int)$isi->DATE_31;
            ?>
                                                ]
                                        },
            <?php
        }
        ?>
                ]
        });

        chart5 = new Highcharts.Chart({
            chart: {
                height: 250,
                width:1320,
                type: 'line',
                renderTo: 'container_detail_mg',
                plotBorderWidth: 1
            },
            title: {
                text: 'Manufacture'
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
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
            legend: {
                                borderColor: '#cccccc',
                                        borderWidth: 1,
                                        borderRadius: 3
                                },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            series: [
                <?php
        foreach ($data_eff_per_group_and_period_mg as $isi) {
            ?>
                                        {
                                        name: '<?php echo $isi->CHR_WORK_CENTER; ?>',
                                        data: [
            <?php
            echo (int)$isi->DATE_1 . ',' . (int)$isi->DATE_2 . ',' . (int)$isi->DATE_3 . ',' . (int)$isi->DATE_4 . ',' . (int)$isi->DATE_5 . ',' . (int)$isi->DATE_6 . ',' . (int)$isi->DATE_7 . ',' . (int)$isi->DATE_8 . ',' . (int)$isi->DATE_9
            . ',' . (int)$isi->DATE_10 . ',' . (int)$isi->DATE_11 . ',' . (int)$isi->DATE_12 . ',' . (int)$isi->DATE_13 . ',' . (int)$isi->DATE_14 . ',' . (int)$isi->DATE_15 . ',' . (int)$isi->DATE_16 . ',' . (int)$isi->DATE_17
            . ',' . (int)$isi->DATE_18 . ',' . (int)$isi->DATE_19 . ',' . (int)$isi->DATE_20 . ',' . (int)$isi->DATE_21 . ',' . (int)$isi->DATE_22 . ',' . (int)$isi->DATE_23 . ',' . (int)$isi->DATE_24 . ',' . (int)$isi->DATE_25
            . ',' . (int)$isi->DATE_26 . ',' . (int)$isi->DATE_27 . ',' . (int)$isi->DATE_28 . ',' . (int)$isi->DATE_29 . ',' . (int)$isi->DATE_30 . ',' . (int)$isi->DATE_31;
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

<div class="row">

                <div class="grid-body">
                    <div class="col-md-12">
                    <table width="50%">
                                <?php echo form_open('pes_new/report_prod_line_stop_c/get_efficiency_prod_per_group', 'class="form-horizontal"'); ?>
                                <tr>
                                    <td width="5%">
                                        <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:120px;" value="<?php echo $date; ?>">
                                    </td>
                                    <td width="95%" colspan="4">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                    </td>
                                </tr>
                                <?php form_close(); ?>
                            </table>

						<ul class="nav nav-tabs">
							<li class="active"><a href="#home" data-toggle="tab">Daily</a></li>
							<!-- <li class=""><a href="#issue" data-toggle="tab">Issue</a></li> -->
							<li class=""><a href="#profile" data-toggle="tab">Monthly</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="home">
								<p class="lead">Report Daily</p>
                                <table width="100%" id='filter' border=0px>
                                    <tr>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_up" style="height: 250px; width: 100%;"></div></td>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_bp" style="height: 250px; width: 100%;"></div></td>
                                    <tr>
                                    <tr>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_dl" style="height: 250px; width: 100%;"></div></td>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_dr" style="height: 250px; width: 100%;"></div></td>
                                    <tr>
                                    <tr>
                                        <td colspan="2" style="height: 250px; width: 100%;border: 1px solid #C4C1BB;"><div id="container_mg" style="height: 250px; width: 100%;"></div></td>
                                    <tr>
                                </table>
                                <div class='pull'>
                                    <div class = 'legend legend-info'>
                                        <strong>Formula : </strong> Total OK / (Work Time / CT ) * 100%
                                    </div >
                                </div>
							</div>
							<div class="tab-pane" id="profile">
								<p class="lead">Report Monthly</p>
                                <table width="100%" id='filter' border=0px>
                                    <tr>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_detail_up" style="height: 250px; width: 100%;"></div></td>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_detail_bp" style="height: 250px; width: 100%;"></div></td>
                                    <tr>
                                    <tr>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_detail_dl" style="height: 250px; width: 100%;"></div></td>
                                        <td style="height: 250px; width: 50%;border: 1px solid #C4C1BB;"><div id="container_detail_dr" style="height: 250px; width: 100%;"></div></td>
                                    <tr>
                                    <tr>
                                        <td colspan="2" style="height: 250px; width: 100%;border: 1px solid #C4C1BB;"><div id="container_detail_mg" style="height: 250px; width: 100%;"></div></td>
                                    <tr>
                                </table>
                                <div class='pull'>
                                    <div class = 'legend legend-info'>
                                        <strong>Formula : </strong> Average per month (Qty / (Work Time / CT ) * 100%) 
                                    </div >
                                </div>
							</div>
                            <!-- <div class="tab-pane" id="issue">
                                <table width='100%' style="margin-bottom: 0px;">
                                    <tr>
                                        <td>
                                            <p class="lead">Issue</p>
                                        </td>
                                        <td style='text-align:right'>
                                            <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Issue')" value="Export to Excel">
                                        </td>
                                    </tr>
                                </table>
                                
                                <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr> 
                                            <th style="text-align:center;" >No</th>
                                            <th style="text-align:center;" >WO Number</th>
                                            <th style="text-align:center;" >Durasi (m)</th>
                                            <th style="text-align:center;" >Start</th>
                                            <th style="text-align:center;" >End</th>
                                            <th style="text-align:center;" >Issue</th>
                                            <th style="text-align:center;" >Corrective Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $x = 1;
                                        foreach ($data_issue as $isi) {
                                            echo "<tr> ";
                                            echo "<td style='text-align:center'>$x</td>";
                                            echo "<td style='text-align:center'>$isi->CHR_WO_NUMBER</td>";
                                            echo "<td style='text-align:center'>$isi->DURATION</td>";
                                            echo "<td style='text-align:center'>$isi->CHR_START</td>";
                                            echo "<td style='text-align:center'>$isi->CHR_END</td>";
                                            echo "<td>".trim($isi->CHR_PROBLEM)."</td>";
                                            echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>".trim($isi->CHR_CORRECTIVE_ACTION)."</td>";
                                            echo "</tr>";
                                            $x++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                    <thead>
                                        <tr> 
                                            <th style="text-align:center;" >No</th>
                                            <th style="text-align:center;" >WO Number</th>
                                            <th style="text-align:center;" >Durasi (m)</th>
                                            <th style="text-align:center;" >Start</th>
                                            <th style="text-align:center;" >End</th>
                                            <th style="text-align:center;" >Issue</th>
                                            <th style="text-align:center;" >Corrective Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $x = 1;
                                        foreach ($data_issue as $isi) {
                                            echo "<tr> ";
                                            echo "<td style='text-align:center'>$x</td>";
                                            echo "<td style='text-align:center'>$isi->CHR_WO_NUMBER</td>";
                                            echo "<td style='text-align:center'>$isi->DURATION</td>";
                                            echo "<td style='text-align:center'>$isi->CHR_START</td>";
                                            echo "<td style='text-align:center'>$isi->CHR_END</td>";
                                            echo "<td>".trim($isi->CHR_PROBLEM)."</td>";
                                            echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>".trim($isi->CHR_CORRECTIVE_ACTION)."</td>";
                                            echo "</tr>";
                                            $x++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div> -->
						</div>
					</div>
                </div>

                <a id='modal1-trigger' data-toggle="modal" data-target="#modal1"></a>

                <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3"><strong ><span id='work-center'></span></strong></h4>
                                    </div>
                                    <div class='form-group'>
                                       <div id='detail_chart2' style='height: 250px; width: 100%;'></div>
                                    </div>
                                    <hr>
                                    <div class="modal-body" id='comment-data'>                                    
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

</div>
