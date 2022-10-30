<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>

<style type="text/css">
    #table-luar {
        font-size: 11px;
    }

    #td_date {
        text-align: center;
        vertical-align: top;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border: 1px;
    }

    #testDiv {
        width: 100%;
        white-space: nowrap;
        overflow-x: scroll;
        overflow-y: visible;
        font-size: 12px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    .td-fixed {
        width: 30px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }

    .blue {
        background-color: #0ED09C;
    }
</style>


<script>
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION PERFORMANCE</strong></a></li>
        </ol>
    </section>
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

    <section class="content">

        <script type="text/javascript">
            window.onload = function() {

                var chart_prod_ok_ng = new CanvasJS.Chart("chart_prod_ok_and_ng", {
                    animationEnabled: true,
                    title: {
                        text: ""
                    },
                    axisX: {
                        title: "Date",
                        // gridThickness: 1,
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
                        valueFormatString: "####"
                    },
                    axisY: {
                        title: "Pcs",
                        gridThickness: 1
                    },
                    data: [{
                            type: "stackedColumn", //change type to bar, line, area, pie, etc
                            click: onClick,
                            color: "#06C449",
                            showInLegend: "true",
                            legendText: "OK Product",
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "horizontal",
                            dataPoints: [
                                <?php
                                foreach ($data_prod_ok_and_ng as $isi) {
                                ?>

                                    {
                                        x: 1,
                                        y: <?php echo $isi->DAOK_01; ?>
                                    },
                                    {
                                        x: 2,
                                        y: <?php echo $isi->DAOK_02; ?>
                                    },
                                    {
                                        x: 3,
                                        y: <?php echo $isi->DAOK_03; ?>
                                    },
                                    {
                                        x: 4,
                                        y: <?php echo $isi->DAOK_04; ?>
                                    },
                                    {
                                        x: 5,
                                        y: <?php echo $isi->DAOK_05; ?>
                                    },
                                    {
                                        x: 6,
                                        y: <?php echo $isi->DAOK_06; ?>
                                    },
                                    {
                                        x: 7,
                                        y: <?php echo $isi->DAOK_07; ?>
                                    },
                                    {
                                        x: 8,
                                        y: <?php echo $isi->DAOK_08; ?>
                                    },
                                    {
                                        x: 9,
                                        y: <?php echo $isi->DAOK_09; ?>
                                    },
                                    {
                                        x: 10,
                                        y: <?php echo $isi->DAOK_10; ?>
                                    },
                                    {
                                        x: 11,
                                        y: <?php echo $isi->DAOK_11; ?>
                                    },
                                    {
                                        x: 12,
                                        y: <?php echo $isi->DAOK_12; ?>
                                    },
                                    {
                                        x: 13,
                                        y: <?php echo $isi->DAOK_13; ?>
                                    },
                                    {
                                        x: 14,
                                        y: <?php echo $isi->DAOK_14; ?>
                                    },
                                    {
                                        x: 15,
                                        y: <?php echo $isi->DAOK_15; ?>
                                    },
                                    {
                                        x: 16,
                                        y: <?php echo $isi->DAOK_16; ?>
                                    },
                                    {
                                        x: 17,
                                        y: <?php echo $isi->DAOK_17; ?>
                                    },
                                    {
                                        x: 18,
                                        y: <?php echo $isi->DAOK_18; ?>
                                    },
                                    {
                                        x: 19,
                                        y: <?php echo $isi->DAOK_19; ?>
                                    },
                                    {
                                        x: 20,
                                        y: <?php echo $isi->DAOK_20; ?>
                                    },
                                    {
                                        x: 21,
                                        y: <?php echo $isi->DAOK_21; ?>
                                    },
                                    {
                                        x: 22,
                                        y: <?php echo $isi->DAOK_22; ?>
                                    },
                                    {
                                        x: 23,
                                        y: <?php echo $isi->DAOK_23; ?>
                                    },
                                    {
                                        x: 24,
                                        y: <?php echo $isi->DAOK_24; ?>
                                    },
                                    {
                                        x: 25,
                                        y: <?php echo $isi->DAOK_25; ?>
                                    },
                                    {
                                        x: 26,
                                        y: <?php echo $isi->DAOK_26; ?>
                                    },
                                    {
                                        x: 27,
                                        y: <?php echo $isi->DAOK_27; ?>
                                    },
                                    {
                                        x: 28,
                                        y: <?php echo $isi->DAOK_28; ?>
                                    },
                                    {
                                        x: 29,
                                        y: <?php echo $isi->DAOK_29; ?>
                                    },
                                    {
                                        x: 30,
                                        y: <?php echo $isi->DAOK_30; ?>
                                    },
                                    {
                                        x: 31,
                                        y: <?php echo $isi->DAOK_31; ?>
                                    }

                                <?php
                                }
                                ?>
                            ]
                        },
                        {
                            type: "stackedColumn", //change type to bar, line, area, pie, etc
                            click: onClick,
                            color: "#FF0000",
                            legendText: "NG Product",
                            showInLegend: "true",
                            //indexLabel: "#total",
                            indexLabelPlacement: "outside",
                            indexLabelOrientation: "horizontal",
                            dataPoints: [
                                <?php
                                foreach ($data_prod_ok_and_ng as $isi) {
                                ?>

                                    {
                                        x: 1,
                                        y: <?php echo $isi->DANG_01; ?>
                                    },
                                    {
                                        x: 2,
                                        y: <?php echo $isi->DANG_02; ?>
                                    },
                                    {
                                        x: 3,
                                        y: <?php echo $isi->DANG_03; ?>
                                    },
                                    {
                                        x: 4,
                                        y: <?php echo $isi->DANG_04; ?>
                                    },
                                    {
                                        x: 5,
                                        y: <?php echo $isi->DANG_05; ?>
                                    },
                                    {
                                        x: 6,
                                        y: <?php echo $isi->DANG_06; ?>
                                    },
                                    {
                                        x: 7,
                                        y: <?php echo $isi->DANG_07; ?>
                                    },
                                    {
                                        x: 8,
                                        y: <?php echo $isi->DANG_08; ?>
                                    },
                                    {
                                        x: 9,
                                        y: <?php echo $isi->DANG_09; ?>
                                    },
                                    {
                                        x: 10,
                                        y: <?php echo $isi->DANG_10; ?>
                                    },
                                    {
                                        x: 11,
                                        y: <?php echo $isi->DANG_11; ?>
                                    },
                                    {
                                        x: 12,
                                        y: <?php echo $isi->DANG_12; ?>
                                    },
                                    {
                                        x: 13,
                                        y: <?php echo $isi->DANG_13; ?>
                                    },
                                    {
                                        x: 14,
                                        y: <?php echo $isi->DANG_14; ?>
                                    },
                                    {
                                        x: 15,
                                        y: <?php echo $isi->DANG_15; ?>
                                    },
                                    {
                                        x: 16,
                                        y: <?php echo $isi->DANG_16; ?>
                                    },
                                    {
                                        x: 17,
                                        y: <?php echo $isi->DANG_17; ?>
                                    },
                                    {
                                        x: 18,
                                        y: <?php echo $isi->DANG_18; ?>
                                    },
                                    {
                                        x: 19,
                                        y: <?php echo $isi->DANG_19; ?>
                                    },
                                    {
                                        x: 20,
                                        y: <?php echo $isi->DANG_20; ?>
                                    },
                                    {
                                        x: 21,
                                        y: <?php echo $isi->DANG_21; ?>
                                    },
                                    {
                                        x: 22,
                                        y: <?php echo $isi->DANG_22; ?>
                                    },
                                    {
                                        x: 23,
                                        y: <?php echo $isi->DANG_23; ?>
                                    },
                                    {
                                        x: 24,
                                        y: <?php echo $isi->DANG_24; ?>
                                    },
                                    {
                                        x: 25,
                                        y: <?php echo $isi->DANG_25; ?>
                                    },
                                    {
                                        x: 26,
                                        y: <?php echo $isi->DANG_26; ?>
                                    },
                                    {
                                        x: 27,
                                        y: <?php echo $isi->DANG_27; ?>
                                    },
                                    {
                                        x: 28,
                                        y: <?php echo $isi->DANG_28; ?>
                                    },
                                    {
                                        x: 29,
                                        y: <?php echo $isi->DANG_29; ?>
                                    },
                                    {
                                        x: 30,
                                        y: <?php echo $isi->DANG_30; ?>
                                    },
                                    {
                                        x: 31,
                                        y: <?php echo $isi->DANG_31; ?>
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
                            color: "#000000",
                            markerType: "none",
                            legendText: "Base on master target",
                            dataPoints: [{
                                    x: 1,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 2,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 3,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 4,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 5,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 6,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 7,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 8,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 9,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 10,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 11,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 12,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 13,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 14,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 15,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 16,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 17,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 18,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 19,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 20,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 21,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 22,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 23,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 24,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 25,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 26,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 27,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 28,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 29,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 30,
                                    y: <?php echo $target; ?>
                                },
                                {
                                    x: 31,
                                    y: <?php echo $target; ?>
                                }
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
                            dataPoints: [{
                                    x: 1,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 2,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 3,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 4,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 5,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 6,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 7,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 8,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 9,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 10,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 11,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 12,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 13,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 14,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 15,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 16,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 17,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 18,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 19,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 20,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 21,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 22,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 23,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 24,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 25,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 26,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 27,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 28,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 29,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 30,
                                    y: <?php echo $threshold_performance; ?>
                                },
                                {
                                    x: 31,
                                    y: <?php echo $threshold_performance; ?>
                                }
                            ]
                        }
                    ],
                    legend: {
                        cursor: 'pointer',
                        itemclick: function(e) {
                            if (typeof(e.dataSeries.visible) === 'undefined' || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } else {
                                e.dataSeries.visible = true;
                            }
                            chart_prod_ok_ng.render();
                        }
                    }
                });
                chart_prod_ok_ng.render();

                function onClick(e) {
                    $.ajax({
                        async: false,
                        type: "POST",
                        url: "<?php echo site_url('pes_new/report_prod_date_c/get_data_perhour'); ?>",
                        data: "work_center=" + '<?php echo $work_center ?>' + "&date=" + e.dataPoint.x + "&period=" + '<?php echo $selected_date ?>',
                        success: function(data) {


                            console.log(data);

                            if (data == 0) {
                                $("#row_perhour").css("display", "none");
                                alert("has no history");
                            } else {
                                $("#row_perhour").css("display", "block");
                                $(".data_perhour").html(data);
                            }

                            if (e.dataPoint.x.length == 1) {
                                var day_of_date = '0' + e.dataPoint.x;
                            } else {
                                var day_of_date = e.dataPoint.x;
                            }

                            if ('<?php echo $selected_date ?>'.substring(4, 6) == '01') {
                                var period_of_date = 'Januari-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '02') {
                                var period_of_date = 'Februari-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '03') {
                                var period_of_date = 'Maret-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '04') {
                                var period_of_date = 'April-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '05') {
                                var period_of_date = 'Mei-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '06') {
                                var period_of_date = 'Juni-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '07') {
                                var period_of_date = 'Juli-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '08') {
                                var period_of_date = 'Agustus-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '09') {
                                var period_of_date = 'September-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '10') {
                                var period_of_date = 'Oktober-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '11') {
                                var period_of_date = 'November-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            } else {
                                var period_of_date = 'Desember-' + '<?php echo $selected_date ?>'.substring(0, 4);
                            }

                            $("#day").html('Productivity Hourly, Date : ' + day_of_date + '-' + period_of_date);
                        },
                        error: function(request) {
                            alert(request.responseText);
                        }
                    });
                }

                var chartLineStop = new CanvasJS.Chart("chartContainerLineStop", {
                    title: {
                        text: ""
                    },
                    axisX: {
                        title: "Date",
                        // gridThickness: 1,
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
                        valueFormatString: "####"
                    },
                    axisY: {
                        title: "Minute(s)",
                        gridThickness: 1
                    },
                    data: [

                        <?php
                        foreach ($data_prod_entry_detail_line_stop as $isi) {
                            if ($isi->CHR_LINE_STOP != 'zTotal') {
                        ?> {

                                    type: "stackedColumn",
                                    legendText: "<?php echo $isi->CHR_LINE_STOP; ?>",
                                    showInLegend: "true",
                                    dataPoints: [{
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
                                    ]
                                },
                        <?php
                            }
                        }
                        ?>
                    ]
                });
                chartLineStop.render();

                var chartNG = new CanvasJS.Chart("chartContainerNG", {
                    title: {
                        text: ""
                    },
                    axisX: {
                        title: "Date",
                        // gridThickness: 1,
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
                        valueFormatString: "####"
                    },
                    axisY: {
                        title: "Pcs",
                        gridThickness: 1
                    },
                    data: [

                        <?php
                        foreach ($data_detail_ng as $isi) {
                            if ($isi->CHR_NG_CATEGORY != 'zTotal') {
                        ?> {

                                    type: "stackedColumn",
                                    legendText: "<?php echo $isi->CHR_NG_CATEGORY; ?>",
                                    showInLegend: "true",
                                    dataPoints: [{
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
                                    ]
                                },
                        <?php
                            }
                        }
                        ?>
                    ],
                    legend: {
                        cursor: "pointer",
                        itemclick: function(e) {
                            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } else {
                                e.dataSeries.visible = true;
                            }
                            chartNG.render();
                        }
                    }
                });
                chartNG.render();

            }
        </script>



        <!--GRID TO DISPLAY DIAGRAM QUALITY-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PROD. PERFORMANCE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">
                                        <select id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;" class="form-control" style="width:150px;">
                                            <?php for ($x = -16; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('pes_new/report_prod_date_c/search_prod_entry/' . date("Ym", strtotime("+$y day")) . '/' . trim($work_center)); ?>" <?php
                                                                                                                                                                                                        if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                                                        }
                                                                                                                                                                                                        ?>> <?php echo date("M Y", strtotime("+$y day")); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="80%">
                                        <select id="e1" onChange="document.location.href = this.options[this.selectedIndex].value;" class="form-control" style="width:150px;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_date_c/search_prod_entry/' . $selected_date . '/' . (trim($row->CHR_WORK_CENTER))); ?>" <?php
                                                                                                                                                                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                                                }
                                                                                                                                                                                                ?>><?php echo trim($row->CHR_WORK_CENTER); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                            </table>

                        </div>
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                        <input name="CHR_WC_SELECTED" value="<?php echo $work_center ?>" type="hidden">
                        <?php echo form_close() ?>

                        <?php if ($data_prod_ok_and_ng == 0) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <div id="chart_prod_ok_and_ng" style="height: 350px; width: 100%;"></div>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM QUALITY-->

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row" id="row_perhour" style="display:none;">
            <div class="col-md-12">
                <div id="data_perhour" class="data_perhour">
                </div>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong id="day">PROD PER HOUR LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="container" style="height: 350px; width: 100%;display:block;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID TO DISPLAY DIAGRAM SUMMARY-->
        <div class="row">
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>EFFICIENCY <?php echo $fiscal_year ?></strong></span>
                    </div>
                    <div class="grid-body">

                        <?php //if ($summary_efficiency == false) { 
                        ?>
                        <!-- <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table> -->
                        <?php // } else { 
                        ?>
                        <iframe src="<?php echo site_url('pes_new/report_prod_date_c/get_summary_efficiency/' . $selected_date . '/' . trim($work_center)); ?>" height="350px" width="100%" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
                        <?php //} 
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>MAN MIN./PCS <?php echo $fiscal_year ?></strong></span>
                    </div>
                    <div class="grid-body">

                        <?php //if ($summary_man_minutes_perpieces == false) { 
                        ?>
                        <!-- <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table> -->
                        <?php //} else { 
                        ?>
                        <iframe src="<?php echo site_url('pes_new/report_prod_date_c/get_summary_manminpcs/' . $selected_date . '/' . trim($work_center)); ?>" height="350px" width="100%" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
                        <?php //} 
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>RATIO RIL <?php echo $fiscal_year ?></strong></span>
                    </div>
                    <div class="grid-body">

                        <?php //if ($summary_ratio_ril == false) { 
                        ?>
                        <!-- <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table> -->
                        <?php //} else { 
                        ?>
                        <iframe src="<?php echo site_url('pes_new/report_prod_date_c/get_summary_ril/' . $selected_date . '/' . trim($work_center)); ?>" height="350px" width="100%" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
                        <!-- <div id="chartSummaryRatioRIL" style="height: 350px; width: 100%;"></div> -->
                        <?php //} 
                        ?>

                    </div>
                </div>
            </div>

        </div>
        <!--GRID TO DISPLAY DIAGRAM SUMMARY-->

        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->
        <div class="row">
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
                    <div class="grid-body">
                        <?php if ($data_efficiency == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('pes_new/report_prod_date_c/get_efficiency/' . $selected_date .  '/' . trim($work_center)); ?>" height="300px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->

        <!--GRID TO DISPLAY DIAGRAM MANPCS CHART-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>MAN MIN./PCS CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_man_minutes_perpieces == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('pes_new/report_prod_date_c/get_manminpcs/' . $selected_date . '/' . trim($work_center)); ?>" height="300px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM MANPCS CHART-->

        <!--GRID TO DISPLAY DIAGRAM RIL CHART-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>RATIO RIL CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_ratio_ril == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('pes_new/report_prod_date_c/get_ril/' . $selected_date  . '/' . trim($work_center)); ?>" height="300px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM RIL CHART-->

        <!--GRID TO DISPLAY GRID TABLE-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PROD. PERFORMANCE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull-right">
                            <input type="button" onclick="tableToExcel('exportToExcel_qty', 'W3C Example Table')" value="Expor to Excel" class="btn btn-primary">
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Back No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part Name</th>
                                        <th colspan='62' style="text-align:center;">Date </th>
                                        <td rowspan="3" style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'>TOTAL OK</td>
                                        <td rowspan="3" style='text-align:center;background:#E34234;color:white;border-right-width: 0;'>TOTAL NG</td>
                                        <th rowspan="3" class='bg-blue' style="text-align:center;">Total </th>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        $date = new DateTime($first_saturday);
                                        $thisMonth = $date->format('m');

                                        $z = 0;
                                        while ($date->format('m') === $thisMonth) {
                                            $datesaturday[$z] = $date->format('j');
                                            $date->modify('next Saturday');
                                            $z++;
                                        }

                                        $date1 = new DateTime($first_sunday);
                                        $thisMonth1 = $date1->format('m');

                                        $y = 0;
                                        while ($date1->format('m') === $thisMonth1) {
                                            $datesunday[$y] = $date1->format('j');
                                            $date1->modify('next Sunday');
                                            $y++;
                                        }

                                        $k = 0;
                                        for ($a = 1; $a <= 31; $a++) {
                                            if ($y == 5 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 62; $x++) {
                                            if ($x % 2 != 0) {
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_prod_entry_qty as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";

                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_01)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_02)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_03)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_04)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_05)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_06)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_07)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_08)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_09)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_10)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_11)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_12)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_13)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_14)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_15)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_16)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_17)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_18)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_19)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_20)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_21)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_22)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_23)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_24)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_25)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_26)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_27)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_28)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_29)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_30)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_31)) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->INT_TOTAL_QTY)) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->INT_TOTAL_NG)) . "</td>";
                                        echo "<td  class='bg-blue'  style='text-align:center;border-right-width: 0.1em;'>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</td>";
                                    ?>
                                        </tr>
                                    <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="pull">

                            <table id="exportToExcel_qty" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Back No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part Name</th>
                                        <th colspan='62' style="text-align:center;">Date </th>
                                        <td rowspan="3" style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'>TOTAL OK</td>
                                        <td rowspan="3" style='text-align:center;background:#E34234;color:white;border-right-width: 0;'>TOTAL NG</td>
                                        <th rowspan="3" class='bg-blue' style="text-align:center;">Total </th>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        $date = new DateTime($first_saturday);
                                        $thisMonth = $date->format('m');

                                        $z = 0;
                                        while ($date->format('m') === $thisMonth) {
                                            $datesaturday[$z] = $date->format('j');
                                            $date->modify('next Saturday');
                                            $z++;
                                        }

                                        $date1 = new DateTime($first_sunday);
                                        $thisMonth1 = $date1->format('m');

                                        $y = 0;
                                        while ($date1->format('m') === $thisMonth1) {
                                            $datesunday[$y] = $date1->format('j');
                                            $date1->modify('next Sunday');
                                            $y++;
                                        }

                                        $k = 0;
                                        for ($a = 1; $a <= 31; $a++) {
                                            if ($y == 5 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 62; $x++) {
                                            if ($x % 2 != 0) {
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_prod_entry_qty as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";

                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_01)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_02)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_03)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_04)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_05)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_06)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_07)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_08)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_09)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_10)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_11)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_12)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_13)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_14)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_15)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_16)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_17)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_18)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_19)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_20)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_21)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_22)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_23)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_24)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_25)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_26)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_27)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_28)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_29)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_30)) . "</td>";
                                        echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_31)) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->INT_TOTAL_QTY)) . "</td>";
                                        echo "<td style='text-align:center;border-right-width: 0;'>" . str_replace(',', '.', number_format($isi->INT_TOTAL_NG)) . "</td>";
                                        echo "<td  class='bg-blue'  style='text-align:center;border-right-width: 0.1em;'>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</td>";
                                    ?>
                                        </tr>
                                    <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong id="day">NG CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>

                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($status_detail_ng == 0) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <div id="chartContainerNG" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID TO DISPLAY DETAIL GRID TABLE-->
        <div class="row">
            <div class="col-lg-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumbs-down"></i>
                        <span class="grid-title"><strong>NG</strong> (Day/Pcs)</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull-right">
                            <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Sheet1')" value="Export to Excel">
                        </div>
                        <table id="example1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>Back No </th>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>NG Desc </th>
                                    <th colspan='31' style=text-align:center;>Date </th>
                                    <th rowspan='2' class="bg-blue" style=text-align:center;>Total </th>
                                </tr>
                                <tr class='gradeX'>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) {
                                        echo "<td style=text-align:center;>$x</td>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $t = 1;
                                foreach ($detail_ng_per_part as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td class='bg-blue' style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                    echo "<td class='bg-blue' style=vertical-align: top;text-align: left;>$isi->CHR_NG_CATEGORY</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_01)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_02)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_03)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_04)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_05)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_06)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_07)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_08)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_09)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_10)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_11)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_12)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_13)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_14)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_15)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_16)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_17)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_18)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_19)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_20)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_21)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_22)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_23)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_24)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_25)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_26)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_27)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_28)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_29)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_30)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_31)) . "</td>";
                                    echo "<td class='bg-blue' style=text-align:center;>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</td>";
                                    echo "</tr>";
                                    $t++;
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-striped table-bordered table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>Back No </th>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>NG Desc </th>
                                    <th colspan='31' style=text-align:center;>Date </th>
                                    <th rowspan='2' class="bg-blue" style=text-align:center;>Total </th>
                                </tr>
                                <tr class='gradeX'>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) {
                                        echo "<td style=text-align:center;>$x</td>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $t = 1;
                                foreach ($detail_ng_per_part as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td class='bg-blue' style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                    echo "<td class='bg-blue' style=vertical-align: top;text-align: left;>$isi->CHR_NG_CATEGORY</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_01)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_02)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_03)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_04)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_05)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_06)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_07)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_08)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_09)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_10)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_11)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_12)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_13)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_14)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_15)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_16)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_17)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_18)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_19)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_20)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_21)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_22)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_23)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_24)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_25)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_26)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_27)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_28)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_29)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_30)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_31)) . "</td>";
                                    echo "<td class='bg-blue' style=text-align:center;>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</td>";
                                    echo "</tr>";
                                    $t++;
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!--GRID TO DISPLAY DIAGRAM-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong id="day">STOP LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>

                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($status_detail_line_stop == 0) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <div id="chartContainerLineStop" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->

        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->
        <div class="row">
            <div class="col-lg-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>STOP LINE</strong> (Minutes)</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull-right">
                            <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel_ls', 'Sheet1')" value="Export to Excel">
                        </div>
                        <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>Line Stop Desc </th>
                                    <th colspan='31' style=text-align:center;>Date </th>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>Total </th>
                                </tr>
                                <tr class='gradeX'>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) {
                                        echo "<td style=text-align:center;>$x</td>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($data_prod_entry_detail_line_stop as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td class='bg-blue' style=vertical-align: top;text-align: left;>$isi->CHR_LINE_STOP</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_01)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_02)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_03)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_04)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_05)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_06)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_07)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_08)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_09)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_10)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_11)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_12)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_13)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_14)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_15)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_16)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_17)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_18)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_19)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_20)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_21)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_22)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_23)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_24)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_25)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_26)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_27)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_28)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_29)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_30)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_31)) . "</td>";
                                    echo "<td class='bg-blue'  style=text-align:center;>" . str_replace(',', '.', number_format($isi->INT_TOTAL)) . "</td>";
                                    echo "</tr>";
                                    $r++;
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel_ls" class="table table-striped table-bordered table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr class='gradeX'>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>Line Stop Desc </th>
                                    <th colspan='31' style=text-align:center;>Date </th>
                                    <th rowspan='2' class='bg-blue' style=text-align:center;>Total </th>
                                </tr>
                                <tr class='gradeX'>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) {
                                        echo "<td style=text-align:center;>$x</td>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($data_prod_entry_detail_line_stop as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td class='bg-blue' style=vertical-align: top;text-align: left;>$isi->CHR_LINE_STOP</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_01)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_02)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_03)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_04)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_05)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_06)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_07)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_08)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_09)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_10)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_11)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_12)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_13)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_14)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_15)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_16)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_17)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_18)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_19)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_20)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_21)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_22)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_23)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_24)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_25)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_26)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_27)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_28)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_29)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_30)) . "</td>";
                                    echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->DATE_31)) . "</td>";
                                    echo "<td class='bg-blue'  style=text-align:center;>" . str_replace(',', '.', number_format($isi->INT_TOTAL)) . "</td>";
                                    echo "</tr>";
                                    $r++;
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->



    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 1
            }
        });
    });
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 1
            }
        });
    });
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: true,
            fixedColumns: {
                leftColumns: 4
            }
        });
    });
</script>