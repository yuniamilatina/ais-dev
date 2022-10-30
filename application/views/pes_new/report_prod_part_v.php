<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script>
    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd/mm/yy'}).val();
    });</script>
<style type="text/css">
    #td_date{
        text-align:center;
        vertical-align:top;
    } 
    #scrooltable{
        width: 100%;
        overflow-x: auto;
        white-space: nowrap; 
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

</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION ENTRY</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION PER-PART </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">

                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td>
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_part_c/search_prod_part/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod . '/' . $work_center . '/' . $back_no); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td>
                                        <?php if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 ) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<? echo site_url('pes_new/report_prod_part_c/search_prod_part/' . $selected_date . '/' . $row->INT_ID_DEPT. '/' . $work_center. '/' . $back_no); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Work Center</td>
                                    <td> <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_part_c/search_prod_part/' . $selected_date . '/' . $id_prod . '/' . trim($row->CHR_WORK_CENTER). '/' . $back_no); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Back Number</td>
                                    <td><select id="e1" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php foreach ($all_back_no as $row) { ?>
                                                <option value="<? echo site_url('pes_new/report_prod_part_c/search_prod_part/' . $selected_date . '/' . $id_prod . '/' . $work_center . '/' . trim($row->CHR_BACK_NO)); ?>" <?php
                                                if (trim($back_no) == trim($row->CHR_BACK_NO)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><? echo trim($row->CHR_BACK_NO); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="scrooltable">
                            <table id="dataTables3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle">No</th>
                                        <th rowspan="2" style="vertical-align: middle">Part Number</th>
                                        <th rowspan="2" style="vertical-align: middle">Part.Name & Model </th>
                                        <th rowspan="2" style="vertical-align: middle">Back No </th>                                        
                                        <th colspan='31' style=text-align:center;>Date </th>
                                        <th rowspan="2" style="vertical-align: middle">Total </th>
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
                                    foreach ($data_prod_entry as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=vertical-align: top;text-align: left;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_01) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_02) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_03) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_04) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_05) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_06) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_07) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_08) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_09) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_10) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_11) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_12) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_13) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_14) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_15) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_16) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_17) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_18) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_19) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_20) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_21) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_22) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_23) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_24) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_25) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_26) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_27) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_28) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_29) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_30) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->DATE_31) . "</td>";
                                        echo "<td style=text-align:center;>" . number_format($isi->INT_TOTAL) . "</td>";
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
                    window.onload = function () {
                        var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    title:{
                                    text: "" },
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
                                                        <?php }
                                                    }
                                                    ?>

                                            ],
                                            valueFormatString: "#" },
                                    axisY: {
                                    title: "Pcs",
                                            gridThickness: 1 },
                                    data: [
                                        {
                                            type: "splineArea", //change type to bar, line, area, pie, etc
                                            color: "#00B050",
                                            legendText: "Qty",
                                            showInLegend: "true",
                                            indexLabelPlacement: "outside",
                                            indexLabelOrientation: "horizontal",
                                            dataPoints: [
                                                <?php foreach ($data_prod_entry_for_diagram as $isi) { ?>
                                                    { x: 1, y: <?php echo $isi->DATE_01; ?> },
                                                    { x: 2, y: <?php echo $isi->DATE_02; ?> },
                                                    { x: 3, y: <?php echo $isi->DATE_03; ?> },
                                                    { x: 4, y: <?php echo $isi->DATE_04; ?> },
                                                    { x: 5, y: <?php echo $isi->DATE_05; ?> },
                                                    { x: 6, y: <?php echo $isi->DATE_06; ?> },
                                                    { x: 7, y: <?php echo $isi->DATE_07; ?> },
                                                    { x: 8, y: <?php echo $isi->DATE_08; ?> },
                                                    { x: 9, y: <?php echo $isi->DATE_09; ?> },
                                                    { x: 10, y: <?php echo $isi->DATE_10; ?> },
                                                    { x: 11, y: <?php echo $isi->DATE_11; ?> },
                                                    { x: 12, y: <?php echo $isi->DATE_12; ?> },
                                                    { x: 13, y: <?php echo $isi->DATE_13; ?> },
                                                    { x: 14, y: <?php echo $isi->DATE_14; ?> },
                                                    { x: 15, y: <?php echo $isi->DATE_15; ?> },
                                                    { x: 16, y: <?php echo $isi->DATE_16; ?> },
                                                    { x: 17, y: <?php echo $isi->DATE_17; ?> },
                                                    { x: 18, y: <?php echo $isi->DATE_18; ?> },
                                                    { x: 19, y: <?php echo $isi->DATE_19; ?> },
                                                    { x: 20, y: <?php echo $isi->DATE_20; ?> },
                                                    { x: 21, y: <?php echo $isi->DATE_21; ?> },
                                                    { x: 22, y: <?php echo $isi->DATE_22; ?> },
                                                    { x: 23, y: <?php echo $isi->DATE_23; ?> },
                                                    { x: 24, y: <?php echo $isi->DATE_24; ?> },
                                                    { x: 25, y: <?php echo $isi->DATE_25; ?> },
                                                    { x: 26, y: <?php echo $isi->DATE_26; ?> },
                                                    { x: 27, y: <?php echo $isi->DATE_27; ?> },                                                { x: 27, y: <?php echo $isi->DATE_01; ?> },
                                                    { x: 28, y: <?php echo $isi->DATE_28; ?> },
                                                    { x: 29, y: <?php echo $isi->DATE_29; ?> },
                                                    { x: 30, y: <?php echo $isi->DATE_30; ?> },
                                                    { x: 31, y: <?php echo $isi->DATE_31; ?> }
                                                <?php } ?>
                                            ]
                                        }
                                    ],
                                    legend: {
                                    
                                    }
                                });

                        chart.render();
                    }
                </script>
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <div class="pull-left grid-tools">
                            <?php echo 'Dept : <b>' . $dept_name . '</b> | Period : <b>' . $selected_date_diagram . '</b> | Work Center : <b>' . $work_center . '</b> | Back No  : <b>' . $back_no . '</b>' ; ?> 
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_prod_entry_for_diagram == 0) { ?>
                            <table width=100% border:1px id='filterdiagram' ><td> No data available in diagram</td></table>
                        <?php } else { ?>
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

    </section>
</aside>


<script type="text/javascript">

    function getLocation() {
        var t = document.getElementById("opt_wcenter");
        var date_t = document.getElementById('datepicker').value;
        var date_fix = date_t.substr(6, 4) + date_t.substr(3, 2) + date_t.substr(0, 2)
        if (<?php echo $set ?> == 0)
        {
            location.href = '<?php echo site_url() ?>/home/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/1'
        } else
        {
            location.href = '<?php echo site_url() ?>/home/form/' + date_fix + '/' + <?php echo $shift; ?> + '/' + t.options[t.selectedIndex].text + '/0'
        }
    }

    function isNumberKey(evt)
    {

        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>
