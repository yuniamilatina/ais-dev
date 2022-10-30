<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script> 

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

 window.onload = function() {
            
            var chart_prod_ok_ng = new CanvasJS.Chart("chart_prod_ok_and_ng",
        {
        animationEnabled: true,
                title:{
                text: "" },
                axisX:{
                title: "Date",
                        // gridThickness: 1,
                        interval: 1,
                        stripLines:[

<?php
for ($a = 0; $a < $x; $a++) {
if ($a == $x - 1) {
    ?>
                                {
                                startValue:<?php echo $datesunday[$a] - 1; ?>,
                                        endValue:<?php echo $datesunday[$a]; ?>,
                                        color:"#FC3322",
                                        opacity: .2
                                }
<?php } else { ?>
                                {
                                startValue:<?php echo $datesunday[$a] - 1; ?>,
                                        endValue:<?php echo $datesunday[$a]; ?>,
                                        color:"#FC3322",
                                        opacity: .2
                                },
    <?php
}
}
?>

                        ],
                        valueFormatString: "####" },
                axisY: {
                title: "Pcs",
                        gridThickness: 1 },
                data: [ {
                type: "stackedColumn", //change type to bar, line, area, pie, etc
                        click: onClick,
                        color: "#06C449",
                        showInLegend: "true",
                        legendText: "OK Product",
                        indexLabelPlacement: "outside",
                        indexLabelOrientation: "horizontal",
                        dataPoints: [
                            <?php
$i = 1;
while ($i <= $sum_date_this_month) {
    $j = 0;
    foreach ($data_prod_ok_and_ng as $isi) {
        if ($i == intval($isi->CHR_DATE)) {
            if ($i != $sum_date_this_month) { {
                    ?>
                                                { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY; ?> },
                    <?php
                    $j = $i;
                }
            } else {
                ?>
                                            { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY; ?> }
                <?php
                $j = $i;
            }
        }
    }

    if ($j != $i) {
        if ($i != $sum_date_this_month) {
            ?>
                                        { x: <?php echo $i; ?>, y: <?php echo 0; ?> },
        <?php } else { ?>
                                        { x: <?php echo $i; ?>, y: <?php echo 0; ?> }
            <?php
        }
    }
    $i++;
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
$i = 1;
while ($i <= $sum_date_this_month) {
$j = 0;
foreach ($data_prod_ok_and_ng as $isi) {
    if ($i == intval($isi->CHR_DATE)) {
        if ($i != $sum_date_this_month) { {
                ?>
                                            { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY_NG; ?> },
                <?php
                $j = $i;
            }
        } else {
            ?>
                                        { x: <?php echo $i; ?>, y: <?php echo $isi->INT_TOTAL_QTY_NG; ?> }
            <?php
            $j = $i;
        }
    }
}

if ($j != $i) {
    if ($i != $sum_date_this_month) {
        ?>
                                    { x: <?php echo $i; ?>, y: <?php echo 0; ?> },
    <?php } else { ?>
                                    { x: <?php echo $i; ?>, y: <?php echo 0; ?> }
        <?php
    }
}
$i++;
}
?>
                        ]
                },
                {
                type: "line",
                        showInLegend: true,
                        lineDashType: "dash",
                        lineThickness: 2,
                        color:"#000000",
                        markerType: "none",
                        legendText: "Base on master target",
                        dataPoints: [
                        {x: 1, y: <?php echo $target; ?>},
                        {x: 2, y: <?php echo $target; ?>},
                        {x: 3, y: <?php echo $target; ?>},
                        {x: 4, y: <?php echo $target; ?>},
                        {x: 5, y: <?php echo $target; ?>},
                        {x: 6, y: <?php echo $target; ?>},
                        {x: 7, y: <?php echo $target; ?>},
                        {x: 8, y: <?php echo $target; ?>},
                        {x: 9, y: <?php echo $target; ?>},
                        {x: 10, y: <?php echo $target; ?>},
                        {x: 11, y: <?php echo $target; ?>},
                        {x: 12, y: <?php echo $target; ?>},
                        {x: 13, y: <?php echo $target; ?>},
                        {x: 14, y: <?php echo $target; ?>},
                        {x: 15, y: <?php echo $target; ?>},
                        {x: 16, y: <?php echo $target; ?>},
                        {x: 17, y: <?php echo $target; ?>},
                        {x: 18, y: <?php echo $target; ?>},
                        {x: 19, y: <?php echo $target; ?>},
                        {x: 20, y: <?php echo $target; ?>},
                        {x: 21, y: <?php echo $target; ?>},
                        {x: 22, y: <?php echo $target; ?>},
                        {x: 23, y: <?php echo $target; ?>},
                        {x: 24, y: <?php echo $target; ?>},
                        {x: 25, y: <?php echo $target; ?>},
                        {x: 26, y: <?php echo $target; ?>},
                        {x: 27, y: <?php echo $target; ?>},
                        {x: 28, y: <?php echo $target; ?>},
                        {x: 29, y: <?php echo $target; ?>},
                        {x: 30, y: <?php echo $target; ?>},
                        {x: 31, y: <?php echo $target; ?>}
                        ]
                }
                ],
                legend: {
                cursor: "pointer",
                        itemclick: function(e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
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
                data: "dept=" + '<?php echo $id_prod ?>' + "&work_center=" + '<?php echo $work_center ?>' + "&date=" + e.dataPoint.x + "&period=" + '<?php echo $selected_date ?>',
                success: function (data) {
                if (data == 0){
                $("#row_perhour").css("display", "none");
                alert("has no history");
                } else{
                $("#row_perhour").css("display", "block");
                $(".data_perhour").html(data);
                }

                if (e.dataPoint.x.length == 1){
                var day_of_date = '0' + e.dataPoint.x;
                } else{
                var day_of_date = e.dataPoint.x;
                }

                if ('<?php echo $selected_date ?>'.substring(4, 6) == '01'){
                var period_of_date = 'Januari-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '02'){
                var period_of_date = 'Februari-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '03'){
                var period_of_date = 'Maret-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '04'){
                var period_of_date = 'April-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '05'){
                var period_of_date = 'Mei-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '06'){
                var period_of_date = 'Juni-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '07'){
                var period_of_date = 'Juli-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '08'){
                var period_of_date = 'Agustus-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '09'){
                var period_of_date = 'September-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '10'){
                var period_of_date = 'Oktober-' + '<?php echo $selected_date ?>'.substring(0, 4);
                } else if ('<?php echo $selected_date ?>'.substring(4, 6) == '11'){
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

}
</script>


        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PRODUCTIVITY CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                         <?php if ($data_prod_ok_and_ng == 0) { ?>
                             <table width=100% id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                               <div id="chart_prod_ok_and_ng" style="height: 300px; width: 100%;"></div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>


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
                        <div id="container" style="height: 300px; width: 100%;display:block;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM-->
