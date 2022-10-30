<script>
    $(document).ready(function() {
        var date = new Date();
        $("#datepicker1").datepicker({
            dateFormat: 'yymmdd'
        }).val();
        $("#datepicker2").datepicker({
            dateFormat: 'yymmdd'
        }).val();

        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }

    });
</script>
<style type="text/css">
    #table-luar {
        font-size: 11px;
    }

    #td_date {
        text-align: center;
        vertical-align: top;
    }

    #filter {
        -webkit-border-horizontal-spacing: 10px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
        margin-bottom: 10px;
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

    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        border-radius: 4px;
        /* border-width: 0.4em;
        border-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
        border-width: 0.4em;
        border-color: #bce8f1;
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
            <li><a href=""><strong>REPORT RIL MONTHLY</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT RIL </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td style="text-align:center" width="10%">
                                        <select class="form-control" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -20; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('pes_new/production_result_c/report_ratio_ril/' . date("Ym", strtotime("+$y day")) . '/' . $work_center); ?>" <?php
                                                                                                                                                                                                    if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$y day")); ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </td>
                                    <td style="text-align:center" width="10%">
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <button class="btn btn-primary" onclick="tableToExcel('exportToExcel', <?php echo $selected_date ?>)" value="Export to Excel">Export to Excel &nbsp;<i class="fa fa-download"></i></button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id="table-luar">

                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>

                                        <th style="text-align: center;">Qty OK + RIL</th>
                                        <th style="text-align: center;">Qty RIL</th>
                                        <th style="text-align: center;">Ratio RIL (%)</th>

                                        <th style="text-align: center;">Amount OK + RIL</th>
                                        <th style="text-align: center;">Amount RIL</th>
                                        <th style="text-align: center;">Ratio Amount RIL (%)</th>

                                        <th style="text-align: center;">Qty RIL Process</th>
                                        <th style="text-align: center;">Ratio RIL Process (%)</th>
                                        <th style="text-align: center;">Amount RIL Process</th>
                                        <th style="text-align: center;">Ratio Amount RIL Process (%)</th>

                                        <th style="text-align: center;">Qty RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio RIL Broken Test (%)</th>
                                        <th style="text-align: center;">Amount RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio Amount RIL Broken Test (%)</th>

                                        <th style="text-align: center;">Qty RIL Setup</th>
                                        <th style="text-align: center;">Ratio RIL Setup (%)</th>
                                        <th style="text-align: center;">Amount RIL Setup</th>
                                        <th style="text-align: center;">Ratio Amount RIL Setup (%)</th>

                                        <th style="text-align: center;">Qty RIL Trial</th>
                                        <th style="text-align: center;">Ratio RIL Trial (%)</th>
                                        <th style="text-align: center;">Amount RIL Trial</th>
                                        <th style="text-align: center;">Ratio Amount RIL Trial (%)</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 0;
                                    foreach ($data as $isi) {
                                        $r++;

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_PR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_PR</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_BT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_BT</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_SU</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_SU</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_TR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_TR</td>";

                                    ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>

                                        <th style="text-align: center;">Qty OK + RIL</th>
                                        <th style="text-align: center;">Qty RIL</th>
                                        <th style="text-align: center;">Ratio RIL (%)</th>

                                        <th style="text-align: center;">Amount OK + RIL</th>
                                        <th style="text-align: center;">Amount RIL</th>
                                        <th style="text-align: center;">Ratio Amount RIL (%)</th>

                                        <th style="text-align: center;">Qty RIL Process</th>
                                        <th style="text-align: center;">Ratio RIL Process (%)</th>
                                        <th style="text-align: center;">Amount RIL Process</th>
                                        <th style="text-align: center;">Ratio Amount RIL Process (%)</th>

                                        <th style="text-align: center;">Qty RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio RIL Broken Test (%)</th>
                                        <th style="text-align: center;">Amount RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio Amount RIL Broken Test (%)</th>

                                        <th style="text-align: center;">Qty RIL Setup</th>
                                        <th style="text-align: center;">Ratio RIL Setup (%)</th>
                                        <th style="text-align: center;">Amount RIL Setup</th>
                                        <th style="text-align: center;">Ratio Amount RIL Setup (%)</th>

                                        <th style="text-align: center;">Qty RIL Trial</th>
                                        <th style="text-align: center;">Ratio RIL Trial (%)</th>
                                        <th style="text-align: center;">Amount RIL Trial</th>
                                        <th style="text-align: center;">Ratio Amount RIL Trial (%)</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 0;
                                    foreach ($data as $isi) {
                                        $r++;

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_PR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_PR</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_BT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_BT</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_SU</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_SU</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_TR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_TR</td>";

                                    ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT RIL MONTHLY DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('pes_new/production_result_c/download_report_ril_monthly_part', 'class="form-horizontal"'); ?>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td style="text-align:center" width="10%">
                                        <select class="form-control" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -20; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('pes_new/production_result_c/report_ratio_ril/' . date("Ym", strtotime("+$y day")) . '/' . trim($work_center)); ?>" <?php
                                                                                                                                                                                                        if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                                                        }
                                                                                                                                                                                                        ?>> <?php echo date("M Y", strtotime("+$y day")); ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </td>
                                    <td style="text-align:center" width="10%">
                                        <select id="e1" class="form-control" style="width:150px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('pes_new/production_result_c/report_ratio_ril/' . $selected_date . '/' . (trim($row->CHR_WORK_CENTER))); ?>" <?php
                                                                                                                                                                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                                                }
                                                                                                                                                                                                ?>><?php echo trim($row->CHR_WORK_CENTER); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <button class="btn btn-primary" onclick="tableToExcel('exportToExcel_workcenter', 'report_ril_by_workcenter')" value="Export to Excel">Export to Excel &nbsp;<i class="fa fa-download"></i></button>
                                    </td>
                                </tr>
                            </table>
                            <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                            <input name="CHR_WORK_CENTER" value="<?php echo $work_center ?>" type="hidden">
                            <?php echo form_close() ?>
                        </div>

                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>

                                        <th style="text-align: center;">Part No</th>
                                        <th style="text-align: center;">Back No</th>
                                        <th style="text-align: center;">Part Name</th>

                                        <th style="text-align: center;">Qty OK + RIL</th>
                                        <th style="text-align: center;">Qty RIL</th>
                                        <th style="text-align: center;">Ratio RIL (%)</th>

                                        <th style="text-align: center;">Amount OK + RIL</th>
                                        <th style="text-align: center;">Amount RIL</th>
                                        <th style="text-align: center;">Ratio Amount RIL (%)</th>

                                        <th style="text-align: center;">Qty RIL Process</th>
                                        <th style="text-align: center;">Ratio RIL Process (%)</th>
                                        <th style="text-align: center;">Amount RIL Process</th>
                                        <th style="text-align: center;">Ratio Amount RIL Process (%)</th>

                                        <th style="text-align: center;">Qty RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio RIL Broken Test (%)</th>
                                        <th style="text-align: center;">Amount RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio Amount RIL Broken Test (%)</th>

                                        <th style="text-align: center;">Qty RIL Setup</th>
                                        <th style="text-align: center;">Ratio RIL Setup (%)</th>
                                        <th style="text-align: center;">Amount RIL Setup</th>
                                        <th style="text-align: center;">Ratio Amount RIL Setup (%)</th>

                                        <th style="text-align: center;">Qty RIL Trial</th>
                                        <th style="text-align: center;">Ratio RIL Trial (%)</th>
                                        <th style="text-align: center;">Amount RIL Trial</th>
                                        <th style="text-align: center;">Ratio Amount RIL Trial (%)</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 0;
                                    foreach ($data_work_center as $isi) {
                                        $r++;

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                        echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PART_NAME</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_PR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_PR</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_BT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_BT</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_SU</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_SU</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_TR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_TR</td>";

                                    ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT RIL DAILY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>


                    <div class="grid-body">
                        <div class="pull">

                            <table width="100%" id='filter' style="margin-bottom:20px;" border=0px>
                                <tr>
                                    <?php echo form_open('pes_new/production_result_c/report_ratio_ril', 'class="form-horizontal"'); ?>
                                    <td style="text-align:center" width="10%">
                                        <input name="CHR_START_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $start_date; ?>">
                                    </td>
                                    <td style="text-align:center" width="2%">Until</td>
                                    <td style="text-align:center" width="10%">
                                        <input name="CHR_END_DATE" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $end_date; ?>">
                                    </td>
                                    <td style="text-align:center" width="8%">
                                        <button style='height:35px;' class='btn btn-success' type='submit' name='daily-filter' value="Filter">Filter&nbsp;<i class="fa fa-filter"></i></button>
                                    </td>
                                    <?php echo form_close(); ?>
                                    <td width="75%" style="text-align:right;">
                                        <button class="btn btn-primary" onclick="tableToExcel('exportToExcel_between', '<?php echo $start_date . '-' . $end_date ?>' )" value="Export to Excel">Export to Excel &nbsp;<i class="fa fa-download"></i></button>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">

                            <table id="example3" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>

                                        <th style="text-align: center;">Qty OK + RIL</th>
                                        <th style="text-align: center;">Qty RIL</th>
                                        <th style="text-align: center;">Ratio RIL (%)</th>

                                        <th style="text-align: center;">Amount OK + RIL</th>
                                        <th style="text-align: center;">Amount RIL</th>
                                        <th style="text-align: center;">Ratio Amount RIL (%)</th>

                                        <th style="text-align: center;">Qty RIL Process</th>
                                        <th style="text-align: center;">Ratio RIL Process (%)</th>
                                        <th style="text-align: center;">Amount RIL Process</th>
                                        <th style="text-align: center;">Ratio Amount RIL Process (%)</th>

                                        <th style="text-align: center;">Qty RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio RIL Broken Test (%)</th>
                                        <th style="text-align: center;">Amount RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio Amount RIL Broken Test (%)</th>

                                        <th style="text-align: center;">Qty RIL Setup</th>
                                        <th style="text-align: center;">Ratio RIL Setup (%)</th>
                                        <th style="text-align: center;">Amount RIL Setup</th>
                                        <th style="text-align: center;">Ratio Amount RIL Setup (%)</th>

                                        <th style="text-align: center;">Qty RIL Trial</th>
                                        <th style="text-align: center;">Ratio RIL Trial (%)</th>
                                        <th style="text-align: center;">Amount RIL Trial</th>
                                        <th style="text-align: center;">Ratio Amount RIL Trial (%)</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 0;
                                    foreach ($data_perdate  as $isi) {
                                        $r++;

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_PR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_PR</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_BT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_BT</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_SU</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_SU</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_TR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_TR</td>";

                                    ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel_between" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>

                                        <th style="text-align: center;">Qty OK + RIL</th>
                                        <th style="text-align: center;">Qty RIL</th>
                                        <th style="text-align: center;">Ratio RIL (%)</th>

                                        <th style="text-align: center;">Amount OK + RIL</th>
                                        <th style="text-align: center;">Amount RIL</th>
                                        <th style="text-align: center;">Ratio Amount RIL (%)</th>

                                        <th style="text-align: center;">Qty RIL Process</th>
                                        <th style="text-align: center;">Ratio RIL Process (%)</th>
                                        <th style="text-align: center;">Amount RIL Process</th>
                                        <th style="text-align: center;">Ratio Amount RIL Process (%)</th>

                                        <th style="text-align: center;">Qty RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio RIL Broken Test (%)</th>
                                        <th style="text-align: center;">Amount RIL Broken Test</th>
                                        <th style="text-align: center;">Ratio Amount RIL Broken Test (%)</th>

                                        <th style="text-align: center;">Qty RIL Setup</th>
                                        <th style="text-align: center;">Ratio RIL Setup (%)</th>
                                        <th style="text-align: center;">Amount RIL Setup</th>
                                        <th style="text-align: center;">Ratio Amount RIL Setup (%)</th>

                                        <th style="text-align: center;">Qty RIL Trial</th>
                                        <th style="text-align: center;">Ratio RIL Trial (%)</th>
                                        <th style="text-align: center;">Amount RIL Trial</th>
                                        <th style="text-align: center;">Ratio Amount RIL Trial (%)</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 0;
                                    foreach ($data_perdate  as $isi) {
                                        $r++;

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_PR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_PR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_PR</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_BT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_BT</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_BT</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_SU</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_SU</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_SU</td>";

                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_NG_QTY_TR</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_AMOUNT_NG_TR</td>";
                                        echo "<td style=text-align:center;>$isi->RATIO_AMOUNT_NG_TR</td>";

                                    ?>
                                        </tr>
                                    <?php
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
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {

        var table = $('#example').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                // sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: {
                leftColumns: 2
            }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();

        var table2 = $('#example2').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                // sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: {
                leftColumns: 2
            }
        });

        table2.on('order.dt search.dt', function() {
            table2.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();

        var table3 = $('#example3').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                // sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: {
                leftColumns: 2
            }
        });

        table3.on('order.dt search.dt', function() {
            table3.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>