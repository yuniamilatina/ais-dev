

<script>
    $(document).ready(function () {
        var date = new Date();
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 30);
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    .ddl3{
        width:50px;
        height: 30px;
    }
</style>

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

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION HOUR</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION HOUR </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('pes_new/report_prod_part_hour_c/search_prod_part', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' >
                                <tr>
                                    <td width=5%>
                                        <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $date; ?>">
                                    </td>
                                    <td width=5%>
                                        <select id="work_center" name="CHR_WORK_CENTER" class="form-control" style="width:150px;">
                                            <?php
                                            foreach ($data_work_center as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($work_center); ?>" > <?php echo trim($work_center); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width=5%>
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                        <?php form_close(); ?>
                                    </td>
                                    <td style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Production Per Hour')" value="Export to Excel" style="margin-bottom: 0px;">
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Jam</th>
                                        <th rowspan="2" style="vertical-align: middle;white-space:pre-wrap ; word-wrap:break-word;">Interface Status</th>
                                        <th rowspan="2" style="vertical-align: middle;">Back No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Target</th>
                                        <th rowspan="2" class='bg bg-green' style="vertical-align: middle;">Qty OK</th>
                                        <th colspan="4" style="text-align:center;">NG</th>
                                        <th rowspan="2" class='bg bg-red' style="vertical-align: middle;">Qty NG</th>
                                        <th rowspan="2" style="vertical-align: middle;white-space:pre-wrap ; word-wrap:break-word;">Scan Date</th>
                                        <th rowspan="2" style="vertical-align: middle;white-space:pre-wrap ; word-wrap:break-word;">Shift</th>
                                        <th rowspan="2" style="vertical-align: middle;">Status</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle;">Breaktest</th>
                                        <th style="vertical-align: middle;">Setup</th>
                                        <th style="vertical-align: middle;">Process</th>
                                        <th style="vertical-align: middle;">Trial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_production as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='vertical-align: middle;'>".$r."</td>";
                                        echo "<td style='vertical-align: middle;'>$isi->CHR_TIME_ENTRY</td>";
                                        echo "<td style=text-align:left;>";
                                        if ($isi->CHR_VALIDATE == 'X') {
                                            echo 'Done';
                                        } else {
                                            echo 'Not Yet';
                                        }
                                        echo "</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TARGET</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_BRKNTEST</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_SETUP</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_PRC</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_TRIAL</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_DATE_ENTRY</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_SHIFT</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_STATUS</td>";
										
										
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                        <tr class='gradeX'>
                                            <th rowspan="2" style="vertical-align: middle;">Jam</th>
                                            <th rowspan="2" style="vertical-align: middle;">Back No</th>
                                            <th rowspan="2" style="vertical-align: middle;">Part No</th>
                                            <th rowspan="2" style="vertical-align: middle;">Part Name</th>
                                            <th rowspan="2" style="vertical-align: middle;">Plan</th>
                                            <th rowspan="2" style="vertical-align: middle;">MP</th>
                                            <th rowspan="2" style="vertical-align: middle;">Target</th>
                                            <th rowspan="2" style="vertical-align: middle;">Qty OK</th>
                                            <th colspan="4" style="text-align:center;">NG</th>
                                            <th rowspan="2" style="vertical-align: middle;">Qty NG</th>
                                            <th rowspan="2" style="vertical-align: middle;">Status</th>
                                            <th rowspan="2" style="vertical-align: middle;white-space:pre-wrap ; word-wrap:break-word;">Interface Status</th>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Breaktest</th>
                                            <th style="vertical-align: middle;">Setup</th>
                                            <th style="vertical-align: middle;">Process</th>
                                            <th style="vertical-align: middle;">Trial</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_production as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='vertical-align: middle;'>$isi->CHR_TIME_ENTRY</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                        echo "<td style=text-align:left;>$isi->INT_QTY_PLAN</td>";
                                        echo "<td style=text-align:left;>$isi->INT_MP</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TARGET</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_BRKNTEST</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_SETUP</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_PRC</td>";
                                        echo "<td style=text-align:left;>$isi->INT_NG_TRIAL</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_STATUS</td>";
										
										echo "<td style=text-align:left;>";
                                        if ($isi->CHR_VALIDATE == 'X') {
                                            echo 'Done';
                                        } else {
                                            echo 'Not Yet';
                                        }
                                        echo "</td>";
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

            <div class="col-md-13">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT LINE STOP HOUR </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Line Stop Per Hour')" value="Export to Excel" style="margin-bottom: 0px;">
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th  style="text-align: center;">No</th>
                                        <th  style="text-align: center;">Start</th>
                                        <th  style="text-align: center;">Stop</th>
                                        <!-- <th  style="text-align: center;">Jam</th> -->
                                        <th  style="text-align: center;white-space:pre-wrap ; word-wrap:break-word;">Line Stop Desc</th>
                                        <th  style="text-align: center;white-space:pre-wrap ; word-wrap:break-word;">Line Stop Category</th>
                                        <th  style="text-align: center;">Scan Date</th>
                                        <th  style="text-align: center;">Shift</th>
                                        <th  style="text-align: center;white-space:pre-wrap ; word-wrap:break-word;">Line Stop Duration (m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_line_stop_production as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='text-align: center;'>".$r."</td>";
                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($isi->CHR_START_DATE))." ".date("H:i", strtotime($isi->CHR_START_TIME))."</td>";
                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($isi->CHR_STOP_DATE))." ".date("H:i", strtotime($isi->CHR_STOP_TIME))."</td>";
                                        // echo "<td style='text-align: center;'>$isi->CHR_TIME_ENTRY</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_LINE_STOP</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_LINE_CAT</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_DATE_ENTRY</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_SHIFT</td>";
                                        echo "<td style=text-align:left;>$isi->SECOND_LINE_STOP</td>";
										
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th  style="text-align: center;">No</th>
                                        <th  style="text-align: center;">Jam</th>
                                        <th  style="text-align: center;white-space:pre-wrap ; word-wrap:break-word;">Line Stop Desc</th>
                                        <th  style="text-align: center;white-space:pre-wrap ; word-wrap:break-word;">Line Stop Category</th>
                                        <th  style="text-align: center;">Scan Date</th>
                                        <th  style="text-align: center;">Shift</th>
                                        <th  style="text-align: center;white-space:pre-wrap ; word-wrap:break-word;">Line Stop Duration (m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_line_stop_production as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='text-align: center;'>".$r."</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_TIME_ENTRY</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_LINE_STOP</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_LINE_CAT</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_DATE_ENTRY</td>";
                                        echo "<td style=text-align:left;>$isi->CHR_SHIFT</td>";
                                        echo "<td style=text-align:left;>$isi->SECOND_LINE_STOP</td>";
										
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

              <!-- <div class="col-md-13">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTIVITY HOURLY | <?php echo $date; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%" colspan="4"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel3', 'Line Stop Per Hour')" value="Export to Excel" style="margin-bottom: 0px;">
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table  class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Work Center</th>
                                        <th rowspan="2" style="vertical-align: middle;">Shift</th>
                                        <th rowspan="2" style="vertical-align: middle;">Prod (%)</th>
                                        <th colspan="12" style="text-align:center;"> Hourly Productivity (%)</th>
                                    </tr>
                                    <tr>
                                        <th  style="vertical-align: middle;">Ke-1</th>
                                        <th  style="vertical-align: middle;">Ke-2</th>
                                        <th  style="vertical-align: middle;">Ke-3</th>
                                        <th  style="vertical-align: middle;">Ke-4</th>
                                        <th  style="vertical-align: middle;">Ke-5</th>
                                        <th  style="vertical-align: middle;">Ke-6</th>
                                        <th  style="vertical-align: middle;">Ke-7</th>
                                        <th  style="vertical-align: middle;">Ke-8</th>
                                        <th  style="vertical-align: middle;">Ke-9</th>
                                        <th  style="vertical-align: middle;">Ke-10</th>
                                        <th  style="vertical-align: middle;">Ke-11</th>
                                        <th  style="vertical-align: middle;">Ke-12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_efficiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='text-align: center;'>".$r."</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->INT_SHIFT</td>";
                                        echo "<td style=text-align:center;>$isi->TOTAL_PERCENTAGE</td>";
                                        echo "<td style=text-align:center;>$isi->ACT1</td>";
                                        echo "<td style=text-align:center;>$isi->ACT2</td>";
                                        echo "<td style=text-align:center;>$isi->ACT3</td>";
                                        echo "<td style=text-align:center;>$isi->ACT4</td>";
                                        echo "<td style=text-align:center;>$isi->ACT5</td>";
                                        echo "<td style=text-align:center;>$isi->ACT6</td>";
                                        echo "<td style=text-align:center;>$isi->ACT7</td>";
                                        echo "<td style=text-align:center;>$isi->ACT8</td>";
                                        echo "<td style=text-align:center;>$isi->ACT9</td>";
                                        echo "<td style=text-align:center;>$isi->ACT10</td>";
                                        echo "<td style=text-align:center;>$isi->ACT11</td>";
                                        echo "<td style=text-align:center;>$isi->ACT12</td>";
										
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table  class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Work Center</th>
                                        <th rowspan="2" style="vertical-align: middle;">Shift</th>
                                        <th rowspan="2" style="vertical-align: middle;">Act / Plan (qty/m)</th>
                                        <th colspan="12" style="text-align:center;"> Hourly Act /Plan (qty/m)</th>
                                    </tr>
                                    <tr>
                                        <th  style="vertical-align: middle;">Ke-1</th>
                                        <th  style="vertical-align: middle;">Ke-2</th>
                                        <th  style="vertical-align: middle;">Ke-3</th>
                                        <th  style="vertical-align: middle;">Ke-4</th>
                                        <th  style="vertical-align: middle;">Ke-5</th>
                                        <th  style="vertical-align: middle;">Ke-6</th>
                                        <th  style="vertical-align: middle;">Ke-7</th>
                                        <th  style="vertical-align: middle;">Ke-8</th>
                                        <th  style="vertical-align: middle;">Ke-9</th>
                                        <th  style="vertical-align: middle;">Ke-10</th>
                                        <th  style="vertical-align: middle;">Ke-11</th>
                                        <th  style="vertical-align: middle;">Ke-12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_efficiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='text-align: center;'>".$r."</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->INT_SHIFT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACTUAL / $isi->INT_PLAN_CT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT1 / $isi->INT_PLAN1</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT2 / $isi->INT_PLAN2</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT3 / $isi->INT_PLAN3</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT4 / $isi->INT_PLAN4</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT5 / $isi->INT_PLAN5</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT6 / $isi->INT_PLAN6</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT7 / $isi->INT_PLAN7</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT8 / $isi->INT_PLAN8</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT9 / $isi->INT_PLAN9</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT10 / $isi->INT_PLAN10</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT11 / $isi->INT_PLAN11</td>";
                                        echo "<td style=text-align:center;>$isi->INT_ACT12 / $isi->INT_PLAN12</td>";
										
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Work Center</th>
                                        <th rowspan="2" style="vertical-align: middle;">Total Percentage</th>
                                        <th rowspan="2" style="vertical-align: middle;">Shift</th>
                                        <th colspan="12" style="text-align:center;">Jam</th>
                                    </tr>
                                    <tr>
                                        <th  style="vertical-align: middle;">Ke-1</th>
                                        <th  style="vertical-align: middle;">Ke-2</th>
                                        <th  style="vertical-align: middle;">Ke-3</th>
                                        <th  style="vertical-align: middle;">Ke-4</th>
                                        <th  style="vertical-align: middle;">Ke-5</th>
                                        <th  style="vertical-align: middle;">Ke-6</th>
                                        <th  style="vertical-align: middle;">Ke-7</th>
                                        <th  style="vertical-align: middle;">Ke-8</th>
                                        <th  style="vertical-align: middle;">Ke-9</th>
                                        <th  style="vertical-align: middle;">Ke-10</th>
                                        <th  style="vertical-align: middle;">Ke-11</th>
                                        <th  style="vertical-align: middle;">Ke-12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_hourly_efficiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style='text-align: center;'>".$r."</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:left;>$isi->TOTAL_PERCENTAGE</td>";
                                        echo "<td style=text-align:center;>$isi->INT_SHIFT</td>";
                                        echo "<td style=text-align:left;>$isi->ACT1</td>";
                                        echo "<td style=text-align:left;>$isi->ACT2</td>";
                                        echo "<td style=text-align:left;>$isi->ACT3</td>";
                                        echo "<td style=text-align:left;>$isi->ACT4</td>";
                                        echo "<td style=text-align:left;>$isi->ACT5</td>";
                                        echo "<td style=text-align:left;>$isi->ACT6</td>";
                                        echo "<td style=text-align:left;>$isi->ACT7</td>";
                                        echo "<td style=text-align:left;>$isi->ACT8</td>";
                                        echo "<td style=text-align:left;>$isi->ACT9</td>";
                                        echo "<td style=text-align:left;>$isi->ACT10</td>";
                                        echo "<td style=text-align:left;>$isi->ACT11</td>";
                                        echo "<td style=text-align:left;>$isi->ACT12</td>";
										
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
            </div> -->

        </div>

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            // fixedColumns: {
            //     leftColumns:2
            // }
        });
    });

    $(document).ready(function () {
        var table = $('#example2').DataTable({
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            // fixedColumns: {
            //     leftColumns:2
            // }
        });
    });

    $(document).ready(function () {
        var table = $('#example3').DataTable({
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            // fixedColumns: {
            //     leftColumns:3
            // }
        });
    });
</script>

<script type="text/javascript" language="javascript">

            function get_data_work_center(){
                var dept_to_work_center = document.getElementById('dept_to_work_center').value;
        
                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
                    data:  {
                            INT_ID_DEPT: dept_to_work_center
                            },
                    success: function (json_data) {
                        $("#work_center").html(json_data['data']);
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
            }
</script>