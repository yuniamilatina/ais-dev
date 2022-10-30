<script>     var tableToExcel = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                        , base64 = function(s) {
return window.btoa(unescape(encodeURIComponent(s)))
    }
, format = function(s, c) {
return s.replace(/{(\w+)}/g, function(m, p) {
    return c[p];
})
}
return function(table, name) {
if (!table.nodeType)
    table = document.getElementById(table)
var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
window.location.href = uri + base64(format(template, ctx))
}
})()
</script>
<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
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
        border-spacing: 10px;
        border-collapse: separate;
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
</style>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/coil_used_c/'); ?>"><span><strong>History Coil Used</strong></span></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-cube"></i>
                        <span class="grid-title"><strong>HISTORY COIL USED</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('raw_material/coil_used_c/history_coil_used', 'class="form-horizontal"'); ?>
                        <table width="100%" id='filter' border=0px style="margin-bottom: -10px;" >
                            <tr>
                                <td width="5%">Date from</td>
                                <td width="10%">
                                    <input name="CHR_DATE_FROM" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo date("d-m-Y", strtotime($date_from)); ?>">
                                </td>
                                <td width="5%">to</td>
                                <td width="10%" style="text-align:right;">
                                    <input name="CHR_DATE_TO" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:240px;" value="<?php echo date("d-m-Y", strtotime($date_to)); ?>">
                                </td>
                                <td width="70%" >
                                    <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                </td>
                                <td width="30%" >
                                </td>
                            </tr>
                            <tr height="50">
                                <td width="80%" colspan="4">
                                </td>
                                <td width="20%" style="text-align:right;">
                                    <a href="<?php echo base_url("index.php/raw_material/coil_used_c/print_coil/X/$date_from/$date_to"); ?>" target="_blank" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Reprint" style="height:30px;font-size:13px;width:100px;color:#000000;">REPRINT ALL</a>
                                </td>
                                <td>
                                    <input type="button" onclick="tableToExcel('exportToExcel', 'history_coil')" value="Expor to Excel" class="btn btn-primary">
                                </td>
                            </tr>
                        </table>
                        <?php form_close(); ?>

                        <div id="table-luar">
                            <table id="example1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Part No Coil</th>
                                        <!-- <th style="text-align: center;">Part No</th> -->
                                        <!-- <th style="text-align: center;">Work Center</th> -->
                                        <th style="text-align: center;">PDS</th>
                                        <th style="text-align: center;">Serial</th>
                                        <th style="text-align: center;">Batch</th>
                                        <th style="text-align: center;">Weight (KG)</th>
                                        <th style="text-align: center;">Actual Weight (KG)</th>
                                        <!-- <th style="text-align: center;">Status</th> -->
                                        <th style="text-align: center;">Date Return</th>
                                        <th style="text-align: center;">Time Return</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_coil as $isi) {
                                        $part_no = substr($isi->CHR_PART_NO, 0, 5) . "-" . substr($isi->CHR_PART_NO, 5, 6) . "-" . substr($isi->CHR_PART_NO, 11, 2);
                                        echo "<td style='text-align: center;'>$i</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_PART_NO_RM</td>";
                                        // echo "<td style='text-align: center;'>$part_no</td>";
                                        // echo "<td style='text-align: center;'>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_PDS_NO</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_SERIAL_NO</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_BATCH</td>";
                                        echo "<td style='text-align: center;'>" . number_format($isi->INT_WEIGHT) . "</td>";
                                        echo "<td style='text-align: center;'>" . number_format($isi->INT_WEIGHT_ACTUAL) . "</td>";
                                        // if ($isi->CHR_MODIFIED_BY == 'Return to WH00'){
                                        //     echo "<td style='text-align: center;' class='bg bg-green'> " . $isi->CHR_MODIFIED_BY . "</td>";
                                        // }else{
                                        //     echo "<td style='text-align: center;' class='bg bg-red'> " . $isi->CHR_MODIFIED_BY . "</td>";
                                        // }
                                        echo "<td style='text-align: center;'> " . date("Y-m-d", strtotime($isi->CHR_MODIFIED_DATE)) . "</td>";
                                        echo "<td style='text-align: center;'> " . date("H:i:s", strtotime($isi->CHR_MODIFIED_TIME)) . "</td>";
                                        ?>
                                    <td style='text-align: center;'>
                                        <a href="<?php echo base_url('index.php/raw_material/coil_used_c/print_coil') . "/" . $isi->INT_ID; ?>" target="_blank" class="label label-success" data-placement="left" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Part No Coil</th>
                                        <!-- <th style="text-align: center;">Part No</th> -->
                                        <!-- <th style="text-align: center;">Work Center</th> -->
                                        <th style="text-align: center;">PDS</th>
                                        <th style="text-align: center;">Serial</th>
                                        <th style="text-align: center;">Batch</th>
                                        <th style="text-align: center;">Weight (KG)</th>
                                        <th style="text-align: center;">Actual Weight (KG)</th>
                                        <!-- <th style="text-align: center;">Status</th> -->
                                        <th style="text-align: center;">Date Return</th>
                                        <th style="text-align: center;">Time Return</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_coil as $isi) {
                                        $part_no = substr($isi->CHR_PART_NO, 0, 5) . "-" . substr($isi->CHR_PART_NO, 5, 6) . "-" . substr($isi->CHR_PART_NO, 11, 2);
                                        echo "<td style='text-align: center;'>$i</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_PART_NO_RM</td>";
                                        // echo "<td style='text-align: center;'>$part_no</td>";
                                        // echo "<td style='text-align: center;'>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_PDS_NO</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_SERIAL_NO</td>";
                                        echo "<td style='text-align: center;'>$isi->CHR_BATCH</td>";
                                        echo "<td style='text-align: center;'>" . number_format($isi->INT_WEIGHT) . "</td>";
                                        echo "<td style='text-align: center;'>" . number_format($isi->INT_WEIGHT_ACTUAL) . "</td>";
                                        // if ($isi->CHR_MODIFIED_BY == 'Return to WH00'){
                                        //     echo "<td style='text-align: center;' class='bg bg-green'> " . $isi->CHR_MODIFIED_BY . "</td>";
                                        // }else{
                                        //     echo "<td style='text-align: center;' class='bg bg-red'> " . $isi->CHR_MODIFIED_BY . "</td>";
                                        // }
                                        echo "<td style='text-align: center;'> " . date("Y-m-d", strtotime($isi->CHR_MODIFIED_DATE)) . "</td>";
                                        echo "<td style='text-align: center;'> " . date("H:i:s", strtotime($isi->CHR_MODIFIED_TIME)) . "</td>";
                                        ?>
                                    <td style='text-align: center;'>
                                        <a href="<?php echo base_url('index.php/raw_material/coil_used_c/print_coil') . "/" . $isi->INT_ID; ?>" target="_blank" class="label label-success" data-placement="left" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                                    $(document).ready(function () {
                                            var table = $('#example1').DataTable({
                                            scrollY: "400px",
                                                    scrollX: true,
                                                    scrollCollapse: true,
                                                    paging: false,
                                                    bFilter: true,
                                                    fixedColumns: {
                                                    leftColumns: 2
                                                    }
                                            });
                                            });

</script>