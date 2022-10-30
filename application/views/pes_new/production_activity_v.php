

<script>
    $(document).ready(function () {
        var date = new Date();
        $("#datepicker1").datepicker({dateFormat: 'yymmdd'}).val();
    });
</script>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
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
            <li><a href=""><strong>PRODUCTION ACTIVITY</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>PRODUCTION ACTIVITY </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('pes_new/production_result_c/production_activity', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' >
                                <tr>
                                    <td width=5%>
                                        <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $date; ?>">
                                    </td>
                                    <td width=5%>
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                        <?php form_close(); ?>
                                    </td>
                                    <td style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Oee')" value="Export to Excel" style="margin-bottom: 0px;">
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th>No</th>
                                        <th>Wo Number</th>
                                        <th>L/N</th>
                                        <th>Ava.</th>
                                        <th>Prod.</th>
                                        <th>Qua.</th>
                                        <th>OEE</th>
                                        <th>Operating <br> Time</th>
                                        <th>Planned <br> Downtime</th>
                                        <th>Prod.<br>  Time</th>
                                        <th>Unplanned <br> Downtime</th>
                                        <th>Prod. <br> Runtime</th>
                                        <th>OK</th>
                                        <th>NG</th>
                                        <th>Target <br> Per Shift</th>
                                        <th>Target <br> By CT</th>
                                        <th>AVG CT Std.</th>
                                        <th>Eff</th>
                                        <th>Reject</th>
                                        <th>LS</th>
                                        <!-- <th>Target <br> Runtime</th> -->
                                        <!-- <th>Start Prod.</th>
                                        <th>Stop Prod.</th>
                                        <th>Start Meet</th>
                                        <th>Stop Meet</th>
                                        <th>Start Break1</th>
                                        <th>Stop Break1</th>
                                        <th>Start Break2</th>
                                        <th>Stop Break2</th>
                                        <th>Start Break3</th>
                                        <th>Stop Break3</th>
                                        <th>Start Break4</th>
                                        <th>Stop Break4</th>
                                        <th>Start Clean</th>
                                        <th>Stop Clean</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WO_NUMBER</td>";
                                        echo "<td style=text-align:center;>$isi->FLG_SHIFT</td>";
                                        echo "<td style=text-align:center;>$isi->INT_AVAILABILITY %</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PRODUCTIVITY %</td>";
                                        echo "<td style=text-align:center;>$isi->INT_QUALITY %</td>";
                                        echo "<td style=text-align:center;>$isi->INT_OEE %</td>";
                                        echo "<td style=text-align:center;>$isi->INT_OPERATING_TIME</td>";
                                        echo "<td style=text-align:center;>".$isi->INT_PLANNED_DOWNTIME."</td>";
                                        echo "<td style=text-align:center;>".$isi->INT_PRODUCTION_TIME."</td>";
                                        echo "<td style=text-align:center;>".$isi->INT_UNPLANNED_DOWNTIME."</td>";
                                        echo "<td style=text-align:center;>".$isi->INT_PRODUCTION_RUNTIME."</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_OK</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TARGET</td>";
                                        echo "<td style=text-align:center;>$isi->INT_PLAN_CT</td>";
                                        echo "<td style=text-align:center;>$isi->AVG_CT_STD</td>";
                                        echo "<td style=text-align:center;>$isi->EFF</td>";
                                        echo "<td style=text-align:center;>$isi->REJECT</td>";
                                        echo "<td style=text-align:center;>$isi->LS</td>";
                                        // echo "<td style=text-align:center;>$isi->INT_TARGET_RUNTIME</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_PROD</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_PROD</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_MEETING</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_MEETING</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_BREAK1</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_BREAK1</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_BREAK2</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_BREAK2</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_BREAK3</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_BREAK3</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_BREAK4</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_BREAK4</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_START_CLEANING</td>";
                                        // echo "<td style=text-align:center;>$isi->CHR_STOP_CLEANING</td>";
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
                                        <th>No</th>
                                        <th>Work Center</th>
                                        <th>L/N</th>
                                        <th>Wo Number</th>
                                        <th>Availability</th>
                                        <th>Produtivity</th>
                                        <th>Quality</th>
                                        <th>OEE</th>
                                        <th>Operating Time</th>
                                        <th>Unplanned Downtime</th>
                                        <th>Planned Downtime</th>
                                        <th>Prod. Time</th>
                                        <th>Prod. Runtime</th>
                                        <th>Total OK</th>
                                        <th>Total NG</th>
                                        <th>Target Production</th>
                                        <th>Target Runtime</th>
                                        <th>Target Per Shift</th>
                                        <!-- <th>Start Prod.</th>
                                        <th>Stop Prod.</th>
                                        <th>Start Meet</th>
                                        <th>Stop Meet</th>
                                        <th>Start Break1</th>
                                        <th>Stop Break1</th>
                                        <th>Start Break2</th>
                                        <th>Stop Break2</th>
                                        <th>Start Break3</th>
                                        <th>Stop Break3</th>
                                        <th>Start Break4</th>
                                        <th>Stop Break4</th>
                                        <th>Start Clean</th>
                                        <th>Stop Clean</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->FLG_SHIFT</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WO_NUMBER</td>";
                                        echo "<td style=text-align:left;>$isi->INT_AVAILABILITY %</td>";
                                        echo "<td style=text-align:left;>$isi->INT_PRODUCTIVITY %</td>";
                                        echo "<td style=text-align:left;>$isi->INT_QUALITY %</td>";
                                        echo "<td style=text-align:left;>$isi->INT_OEE %</td>";
                                        echo "<td style=text-align:left;>$isi->INT_OPERATING_TIME</td>";
                                        echo "<td style=text-align:left;>".$isi->INT_UNPLANNED_DOWNTIME."</td>";
                                        echo "<td style=text-align:left;>".$isi->INT_PLANNED_DOWNTIME."</td>";
                                        echo "<td style=text-align:left;>".$isi->INT_PRODUCTION_TIME."</td>";
                                        echo "<td style=text-align:left;>".$isi->INT_PRODUCTION_RUNTIME."</td>";
                                        echo "<td style=text-align:center;>$isi->INT_TOTAL_OK</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TOTAL_NG</td>";
                                        echo "<td style=text-align:left;>$isi->INT_PLAN_CT</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TARGET_RUNTIME</td>";
                                        echo "<td style=text-align:left;>$isi->INT_TARGET</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_PROD</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_PROD</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_MEETING</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_MEETING</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_BREAK1</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_BREAK1</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_BREAK2</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_BREAK2</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_BREAK3</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_BREAK3</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_BREAK4</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_BREAK4</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_START_CLEANING</td>";
                                        // echo "<td style=text-align:left;>$isi->CHR_STOP_CLEANING</td>";
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
            fixedColumns: {
                leftColumns:2
            }
        });
    });

</script>
