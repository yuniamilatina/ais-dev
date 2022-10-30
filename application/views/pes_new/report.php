<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'yymmdd'}).val();
        $("#datepicker2").datepicker({dateFormat: 'yymmdd'}).val();

    });
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
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

<!-- <script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script> -->

<!-- <aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT RATIO RIL</strong></a></li>
        </ol>
    </section> -->

    <section class="content">

        <div class="row">
            <div class="grid-body">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="<?php echo $monthly; ?>"><a href="#monthly" data-toggle="tab">Monthly</a></li>
                        <li class="<?php echo $daily; ?>"><a href="#daily" data-toggle="tab">Daily</a></li>
                        <!-- <li class=""><a href="#top5" data-toggle="tab">Top 5</a></li> -->
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane <?php echo $monthly; ?>" id="monthly">
                            <p class="lead">MONTHLY RIL</p>
                                <div class="grid-body">
                                    <div class="pull">
                                    <table width="100%" id='filter'>
                                        <tr>
                                            <td style="text-align:center" width="10%">
                                                <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                                    <?php for ($x = -34; $x <= 0; $x++) { $y = $x * 28 ?>
                                                        <option value="<?php echo site_url('pes_new/production_result_c/report_ratio_ril/' . date("Ym", strtotime("+$y day")) ); ?>" <?php
                                                        if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                            echo 'SELECTED';
                                                        }
                                                        ?> > <?php echo date("M Y", strtotime("+$y day")); ?> 
                                                        </option>
                                                            <?php } ?>

                                                </select>
                                            </td>
                                            <td style="text-align:center" width="10%">
                                            </td>
                                            <td width="75%" style="text-align:right;">
                                                <button class="btn btn-primary" onclick="tableToExcel('exportToExcel', <?php echo $selected_date ?>)" value="Export to Excel" >Export to Excel &nbsp;<i class="fa fa-download"></i></button>
                                            </td>
                                    </tr>
                                    </table>
                                </div>
                                <div id="table-luar">
                                    
                                    <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
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

                        <div class="tab-pane <?php echo $daily; ?>" id="daily">
                            <p class="lead">DAILY RIL</p>
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
                                                    <button style='height:35px;' class='btn btn-success'  type='submit' name='daily-filter' value="Filter" >Filter&nbsp;<i class="fa fa-filter"></i></button>
                                                </td>
                                            <?php echo form_close(); ?>
                                            <td width="75%" style="text-align:right;">
                                                <button class="btn btn-primary" onclick="tableToExcel('exportToExcel_between', '<?php echo $start_date.'-'.$end_date ?>' )" value="Export to Excel" >Export to Excel &nbsp;<i class="fa fa-download"></i></button>
                                            </td>
                                    </tr>
                                    </table>

                                </div>
                                <div id="table-luar">
                                    
                                    <table id="exportToExcel_between" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
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

                        <!-- <div class="tab-pane" id="top5">
                            <p class="lead">TOP 5 RIL</p>
                            <div class="grid-body">
                                <div class="pull">
                                    <table width="100%" id='filter'>
                                        <tr>
                                            <td style="text-align:center" width="10%">
                                                <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                                    <?php for ($x = -4; $x <= 0; $x++) { $y = $x * 28 ?>
                                                        <option value="<?php echo site_url('pes_new/production_result_c/report_ratio_ril/' . date("Ym", strtotime("+$y day")) ); ?>" <?php
                                                        if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                            echo 'SELECTED';
                                                        }
                                                        ?> > <?php echo date("M Y", strtotime("+$y day")); ?> 
                                                        </option>
                                                            <?php } ?>

                                                </select>
                                            </td>
                                            <td style="text-align:center" width="10%">
                                            <select id="e1" class="form-control" style="width:150px;">
                                                <?php foreach ($all_work_centers as $row) { ?>
                                                    <option value="<? echo site_url('pes_new/production_result_c/report_ratio_ril/' . $selected_date . '/' . (trim($row->CHR_WCENTER))); ?>" <?php
                                                    if (trim($work_center) == trim($row->CHR_WCENTER)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_WCENTER); ?></option>
                                                <?php } ?>
                                                </select>
                                            </td>
                                            <td width="75%" style="text-align:right;">
                                                <button class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'report_ratio_ril_by_month')" value="Export to Excel" >Export to Excel &nbsp;<i class="fa fa-download"></i></button>
                                            </td>
                                    </tr>
                                    </table>
                                </div>
                                <div id="table-luar">
                                    
                                    <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
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
                        </div> -->

                    </div>
                </div>
            </div>
        </div>

    </section>
<!-- </aside> -->
