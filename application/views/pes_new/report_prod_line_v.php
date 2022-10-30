<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>

<style type="text/css">
    #td_date{
        text-align:center;
        vertical-align:top;
    } 
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
    }
    .td-fixed{
        width: 10px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btn:hover {
        background: #1E90FF;
        background-image: -webkit-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -moz-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -ms-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: -o-linear-gradient(top, #1E90FF, #1E90FF);
        background-image: linear-gradient(to bottom, #1E90FF, #1E90FF);
        color:white;
    }

</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION LINE</strong></a></li>
        </ol>
    </section>

    <section class="content">

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

        <div class="row">
            <div class="col-md-12">
                <script type="text/javascript">
                            window.onload = function() {
                            var chart = new CanvasJS.Chart("chartContainer",
                            {
                            theme: "theme1", animationEnabled: true,
                                    title:{
                                    text: ""
                                    },
                                    axisX:{
                                    title: "Date",
                                            gridThickness: 1,
                                            interval: 1,
                                            stripLines:[

<?php
for ($a = 0; $a < $x; $a++) {
    if ($a == $x - 1) {
        ?>
                                                    {
                                                    startValue:<?php echo $datesunday[$a] - 1; ?>,
                                                            endValue:<?php echo $datesunday[$a]; ?>,
                                                            color:"#C23B22"
                                                    }
    <?php } else { ?>
                                                    {
                                                    startValue:<?php echo $datesunday[$a] - 1; ?>,
                                                            endValue:<?php echo $datesunday[$a]; ?>,
                                                            color:"#C23B22"
                                                    },
        <?php
    }
}
?>

                                            ],
                                            valueFormatString: "####"
                                    },
                                    axisY: {
                                    title: "Productivity",
                                            gridThickness: 1
                                    },
                                    data: [
                                    {
                                    click: function(e) {
                                    alert("dataSeries Event => Type: " + e.dataSeries.type + ", dataPoint { x:" + e.dataPoint.x + ", y: " + e.dataPoint.y + " }");
                                    },
                                            type: "splineArea", //change type to bar, line, area, pie, etc
                                            color: "#1E90FF",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "horizontal",
                                            dataPoints: [

<?php
$sum_date_this_month = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
$i = 1;
while ($i <= $sum_date_this_month) {

    $j = 0;
    foreach ($data_prod_entry_for_diagram as $isi) {
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
                                            //							{
                                            //								type: "spline",
                                            //								showInLegend: true,
                                            //								lineDashType: "dash",
                                            //								lineThickness: 2,
                                            //								markerType: "none",
                                            //								legendText: "Target Productivity",
                                            //								dataPoints: [
                                            //									{x: 1, y: 50},
                                            //									{x: 2, y: 50},
                                            //									{x: 3, y: 50},
                                            //									{x: 4, y: 50},
                                            //									{x: 5, y: 50},
                                            //									{x: 6, y: 50},
                                            //									{x: 7, y: 50},
                                            //									{x: 8, y: 50},
                                            //									{x: 9, y: 50},
                                            //									{x: 10, y: 50},
                                            //									{x: 11, y: 50},
                                            //									{x: 12, y: 50},
                                            //									{x: 13, y: 50},
                                            //									{x: 14, y: 50},
                                            //									{x: 15, y: 50},
                                            //									{x: 16, y: 50},
                                            //									{x: 17, y: 50},
                                            //									{x: 18, y: 50},
                                            //									{x: 19, y: 50},
                                            //									{x: 20, y: 50},
                                            //									{x: 21, y: 50},
                                            //									{x: 22, y: 50},
                                            //									{x: 23, y: 50},
                                            //									{x: 24, y: 50},
                                            //									{x: 25, y: 50},
                                            //									{x: 26, y: 50},
                                            //									{x: 27, y: 50},
                                            //									{x: 28, y: 50},
                                            //									{x: 29, y: 50},
                                            //									{x: 30, y: 50},
                                            //									{x: 31, y: 50}
                                            //								]
                                            //							}
                                    ],
                                    legend: {
                                    cursor: "pointer",
                                            itemclick: function(e) {
                                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                            e.dataSeries.visible = false;
                                            } else {
                                            e.dataSeries.visible = true;
                                            }
                                            chart.render();
                                            }
                                    }
                            });
                                    chart.render();
                            }
                </script>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>PROD. LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">

                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="15%">Periode</td>
                                    <td width="20%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_line_c/search_prod_entry/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod . '/' . $work_center); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td>Department</td>
                                    <td>
                                        <? if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 ) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<? echo site_url('pes_new/report_prod_line_c/search_prod_entry/' . $selected_date . '/' . $row->INT_ID_DEPT); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><? echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Work Center</td>
                                    <td> <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_line_c/search_prod_entry/' . $selected_date . '/' . $id_prod . '/' . (trim($row->CHR_WORK_CENTER))); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>

                                    <td></td>
                                    <td>
                                        <div style='font-size: 14px;' class="pull-right">
                                            <strong class='badge bg-blue'>TOTAL : <?php echo number_format($total); ?></strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <?php if ($data_prod_entry_for_diagram == 0) { ?>
                            <table width=100% border:1px; id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>

                    </div>                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PROD. LINE </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="1" style="vertical-align: middle">No</th>
                                        <th rowspan="1" style="vertical-align: middle">Work Center</th>
                                        <th rowspan="1" style="vertical-align: middle">Part Number</th>
                                        <th rowspan="1" style="vertical-align: middle">Back No </th>                                        
                                        <th rowspan="1" style="vertical-align: middle">Part.Name & Model </th>
                                        <th rowspan="1" style="vertical-align: middle">Date </th> 
    <!--                                    <th rowspan="1" style="vertical-align: middle">Prod </th>-->
                                        <th rowspan="1" style="vertical-align: middle">Shift </th> 										
                                        <th rowspan="1" style="vertical-align: middle">OK </th>
                                        <th rowspan="1" style="vertical-align: middle">NG </th>
                                        <th rowspan="1" style="vertical-align: middle">Total </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    $session = $this->session->all_userdata();
                                    foreach ($data_prod_entry as $isi) {

                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_ONLY_DATE-$isi->CHR_ONLY_MONTH-$isi->CHR_ONLY_YEAR</td>";
//                                    echo "<td style=text-align:center;>$isi->CHR_DEPT</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_SHIFT</td>";
                                        echo "<td style=text-align:center;><label class='label label-success'>$isi->INT_TOTAL_QTY</label></td>";
                                        echo "<td style=text-align:center;><label class='label label-danger'>$isi->INT_TOTAL_NG</label></td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL</td>";
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



    </section>
</aside>

