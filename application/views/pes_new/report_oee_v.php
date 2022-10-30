
<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">

    #table-luar{
        font-size: 11px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
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
        border : 1px;
    }

    #testDiv{
        width: 100%;
        white-space: nowrap; 
        overflow-x:scroll;
        overflow-y:visible;
        font-size: 12px;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
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
            <li><a href=""><strong>REPORT OEE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT OEE </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="vertical-align:top" width="80%">
                                        <select class="ddl2"  onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -3; $x <= 0; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('pes_new/production_result_c/report_oee/' . date("Ym", strtotime("+$x month"))); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> 
                                                </option>
                                                    <?php } ?>

                                         </select>
                                    </td>
                                    <td width="10%" style="text-align:right;">
                                    <?php echo form_open('pes_new/production_activity_c/download_eff_production', 'class="form-horizontal"'); ?>
                                    <input name="CHR_PERIOD" value="<?php echo $selected_date ?>" type="hidden">
                                    <input type="submit" style="margin-bottom: 20px;" class="btn btn-primary"   value="Export to Template" ></input>
                                    <?php echo form_close() ?>
                                    </td>
                                    <td width="10%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Report Oee')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="vertical-align: middle;">No</th>
                                        <th style="vertical-align: middle;">Work Center</th>
                                        <th style='background:#2A89D1;color:#FFFFFF;vertical-align: middle;'>OEE (%)</th>
                                        <th style="vertical-align: middle;">AVA (%)</th>
                                        <th style="vertical-align: middle;">PERF (%)</th>
                                        <th style="vertical-align: middle;">QUA (%)</th>
                                        <th style="text-align:center;">Operating <br> Time (s) </th>
                                        <th style="text-align:center;">Bridging & <br> BreakTime (s) </th>
                                        <th style="text-align:center;">Prod. <br> Time (s) </th>
                                        <th style="text-align:center;">Line <br> Stop (s) </th>
                                        <th style="text-align:center;">Prod. <br> Runtime (s) </th>
                                        <th style="text-align:center;">AVG <br> CT</th>
                                        <th style="text-align:center;">Target <br> Runtime</th>
                                        <th style="text-align:center;">Total <br> OK</th>
                                        <th style="text-align:center;">Total <br> NG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {

                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {
                                            echo "<tr style='text-align:center;background:#DFDFDF;border-right-width: 0;'>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$r</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='background:#2A89D1;color:#FFFFFF;text-align:center;border-right-width: 0.1em;'>" . str_replace('.',',',$isi->OEE) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace('.',',',$isi->INT_AVAILABILITY) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace('.',',',$isi->INT_PRODUCTIVITY) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace('.',',',$isi->INT_QUALITY) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_OPERATING_TIME)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_PLANNED_DOWNTIME)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_PRODUCTION_TIME)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_UNPLANNED_DOWNTIME)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_PRODUCTION_RUNTIME)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace('.',',',$isi->INT_CT) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_TARGET_RUNTIME)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_TOTAL_OK)) . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->INT_TOTAL_NG)) . "</td>";
                                        }else{
                                            echo "<tr style='text-align:center;border-right-width: 0;'>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='background:#3ca1f0;color:#FFFFFF;text-align:center;border-right-width: 0.1em;'>" . str_replace('.',',',$isi->OEE)  . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace('.',',',$isi->INT_AVAILABILITY) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace('.',',',$isi->INT_PRODUCTIVITY) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace('.',',',$isi->INT_QUALITY) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_OPERATING_TIME)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_PLANNED_DOWNTIME)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_PRODUCTION_TIME)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_UNPLANNED_DOWNTIME)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_PRODUCTION_RUNTIME)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->INT_CT) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_TARGET_RUNTIME)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_TOTAL_OK)) . "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->INT_TOTAL_NG)) . "</td>";
                                        }
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="vertical-align: middle;">No</th>
                                        <th style="vertical-align: middle;">Work Center</th>
                                        <th style='background:#2A89D1;color:#FFFFFF;vertical-align: middle;'>OEE (%)</th>
                                        <th style="vertical-align: middle;">AVA (%)</th>
                                        <th style="vertical-align: middle;">PERF (%)</th>
                                        <th style="vertical-align: middle;">QUA (%)</th>
                                        <th style="text-align:center;">Operating <br> Time (s) </th>
                                        <th style="text-align:center;">Bridging & <br> BreakTime (s) </th>
                                        <th style="text-align:center;">Prod. <br> Time (s) </th>
                                        <th style="text-align:center;">Line <br> Stop (s) </th>
                                        <th style="text-align:center;">Prod. <br> Runtime (s) </th>
                                        <th style="text-align:center;">AVG <br> CT</th>
                                        <th style="text-align:center;">Target <br> Runtime</th>
                                        <th style="text-align:center;">Total <br> OK</th>
                                        <th style="text-align:center;">Total <br> NG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {

                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {
                                            echo "<tr style='text-align:center;background:#DFDFDF;border-right-width: 0;'>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$r</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='background:#2A89D1;color:#FFFFFF;text-align:center;border-right-width: 0.1em;'>" . $isi->OEE . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_AVAILABILITY</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_PRODUCTIVITY</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_QUALITY</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_OPERATING_TIME</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_PLANNED_DOWNTIME</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_PRODUCTION_TIME</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_UNPLANNED_DOWNTIME</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_PRODUCTION_RUNTIME</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_CT</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_TARGET_RUNTIME</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_TOTAL_OK</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>$isi->INT_TOTAL_NG</td>";
                                        }else{
                                            echo "<tr style='text-align:center;border-right-width: 0;'>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='background:#3ca1f0;color:#FFFFFF;text-align:center;border-right-width: 0.1em;'>" . $isi->OEE . "</td>";
                                            echo "<td style=text-align:center;>$isi->INT_AVAILABILITY</td>";
                                            echo "<td style=text-align:center;>$isi->INT_PRODUCTIVITY</td>";
                                            echo "<td style=text-align:center;>$isi->INT_QUALITY</td>";
                                            echo "<td style=text-align:center;>$isi->INT_OPERATING_TIME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_PLANNED_DOWNTIME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_PRODUCTION_TIME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_UNPLANNED_DOWNTIME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_PRODUCTION_RUNTIME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_CT</td>";
                                            echo "<td style=text-align:center;>$isi->INT_TARGET_RUNTIME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_TOTAL_OK</td>";
                                            echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        }
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div class='pull'>
                            <div class = 'legend legend-info'>
                                <strong>Formula : </strong> 
                                <br><strong>Production Time </strong>= Operating Time  / Bridging & Breaktime
                                <br><strong>Production Runtime </strong>= Production Time  / Line Stop
                                <br><strong>Target Runtime </strong>= Production Runtime  / CT per part
                                <br>
                                <br><strong>AVA (Availability) </strong>= Production Runtime  / Production Time
                                <br><strong>PERF (Performance) </strong>= Total OK / Target Runtime
                                <br><strong>QUA (Quality) </strong>= Total OK / (Total OK - Total NG)
                                <br><strong>OEE </strong>= Availability x Performance x Quality
                            </div >
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
                                                $(document).ready(function () {

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
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 2
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                });

</script>