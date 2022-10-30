
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

    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-left-width: 0.4em;
        border-left-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-left-width: 0.4em;
        border-left-color: #bce8f1;
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

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 25);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT MTTR DIES</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT MTTR DIES</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="vertical-align:top" width="10%">
                                        <select class="ddl2" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -3; $x <= 0; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('mte/report_line_stop_c/report_mttr_dies/' . date("Y", strtotime("+$x year")) . '/'. $id_product_group); ?>" <?php
                                                if ($selected_date == date("Y", strtotime("+$x year"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Y", strtotime("+$x year")); ?> 
                                                </option>
                                                    <?php } ?>

                                         </select>
                                    </td>
                                    <td style="vertical-align:top" width="10%">
                                            <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php foreach ($all_product_group as $row) { ?>
                                                    <option value="<?php echo site_url('mte/report_line_stop_c/report_mttr_dies/' . $selected_date . '/' . $row->INT_ID); ?>" <?php
                                                    if ($id_product_group == $row->INT_ID) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_PRODUCT_GROUP); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Report MTTR DIES')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;border-right: 1px solid #cdd0d4;">Work Center</th>
                                        <th colspan='36' style="text-align:center;">MTTR DIES (M)</th>
                                    </tr>
                                    <tr class='gradeX'>

                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Jan</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Feb</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Mar</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Apr</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">May</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Jun</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Jul</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Aug</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Sep</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Oct</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Nov</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Dec</th>

                                    </tr>
                                        
                                    <tr class='gradeX'>

                                    <?php for($x = 1; $x <= 12; $x++) { ?>
                                        <th colspan="1" style="text-align: center;">RT</th>
                                        <th colspan="1" style="text-align: center;">&Sigma; R</th>
                                        <th colspan="1" style="text-align: center;border-right: 1px solid #cdd0d4;">MTTR DIES</th>
                                    <?php } ?>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_mttr_dies as $isi) {
                                        
                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {
                                            echo "<tr style='text-align:center;border-right-width: 0;'>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'></td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;font-weight:600;border-right: 1px solid #cdd0d4;  '>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT01</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS01</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN01</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT02</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS02</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN02</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT03</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS03</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN03</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT04</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS04</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN04</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT05</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS05</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN05</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT06</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS06</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN06</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT07</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS07</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN07</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT08</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS08</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN08</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT09</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS09</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN09</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT10</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS10</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN10</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT11</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS11</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN11</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT12</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS12</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN12</td>";
                                        }else{
                                            echo "<tr style='text-align:center;border-right-width: 0;'>";
                                            echo "<td style='text-align:center;'>$r</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='text-align:center;'>$isi->WT01</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS01</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN01</td>";
                                            echo "<td style='text-align:center;'>$isi->WT02</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS02</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN02</td>";
                                            echo "<td style='text-align:center;'>$isi->WT03</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS03</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN03</td>";
                                            echo "<td style='text-align:center;'>$isi->WT04</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS04</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN04</td>";
                                            echo "<td style='text-align:center;'>$isi->WT05</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS05</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN05</td>";
                                            echo "<td style='text-align:center;'>$isi->WT06</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS06</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN06</td>";
                                            echo "<td style='text-align:center;'>$isi->WT07</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS07</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN07</td>";
                                            echo "<td style='text-align:center;'>$isi->WT08</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS08</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN08</td>";
                                            echo "<td style='text-align:center;'>$isi->WT09</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS09</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN09</td>";
                                            echo "<td style='text-align:center;'>$isi->WT10</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS10</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN10</td>";
                                            echo "<td style='text-align:center;'>$isi->WT11</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS11</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN11</td>";
                                            echo "<td style='text-align:center;'>$isi->WT12</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS12</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN12</td>";
                                            $r++;
                                        }

                                        

                                        ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;border-right: 1px solid #cdd0d4;">Work Center</th>
                                        <th colspan='36' style="text-align:center;">MTTR DIES(M)</th>
                                    </tr>
                                    <tr class='gradeX'>

                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Jan</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Feb</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Mar</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Apr</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">May</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Jun</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Jul</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Aug</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Sep</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Oct</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Nov</th>
                                        <th colspan="3" style="text-align: center;background:whitesmoke;border-left: 1px solid #cdd0d4;">Dec</th>

                                    </tr>
                                        
                                    <tr class='gradeX'>
                                    <?php for($x = 1; $x <= 12; $x++) { ?>
                                        <th colspan="1" style="text-align: center;">RT</th>
                                        <th colspan="1" style="text-align: center;">&Sigma; R</th>
                                        <th colspan="1" style="text-align: center;border-right: 1px solid #cdd0d4;">MTTR DIES</th>
                                    <?php } ?>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_mttr_dies as $isi) {
                                        
                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {
                                            echo "<tr style='text-align:center;border-right-width: 0;'>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'></td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;font-weight:600;border-right: 1px solid #cdd0d4;  '>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT01</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS01</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN01</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT02</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS02</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN02</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT03</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS03</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN03</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT04</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS04</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN04</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT05</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS05</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN05</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT06</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS06</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN06</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT07</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS07</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN07</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT08</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS08</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN08</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT09</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS09</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN09</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT10</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS10</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN10</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT11</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS11</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN11</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->WT12</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>$isi->CLS12</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN12</td>";
                                        }else{
                                            echo "<tr style='text-align:center;border-right-width: 0;'>";
                                            echo "<td style='text-align:center;'>$r</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td style='text-align:center;'>$isi->WT01</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS01</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN01</td>";
                                            echo "<td style='text-align:center;'>$isi->WT02</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS02</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN02</td>";
                                            echo "<td style='text-align:center;'>$isi->WT03</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS03</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN03</td>";
                                            echo "<td style='text-align:center;'>$isi->WT04</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS04</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN04</td>";
                                            echo "<td style='text-align:center;'>$isi->WT05</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS05</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN05</td>";
                                            echo "<td style='text-align:center;'>$isi->WT06</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS06</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN06</td>";
                                            echo "<td style='text-align:center;'>$isi->WT07</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS07</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN07</td>";
                                            echo "<td style='text-align:center;'>$isi->WT08</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS08</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN08</td>";
                                            echo "<td style='text-align:center;'>$isi->WT09</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS09</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN09</td>";
                                            echo "<td style='text-align:center;'>$isi->WT10</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS10</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN10</td>";
                                            echo "<td style='text-align:center;'>$isi->WT11</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS11</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN11</td>";
                                            echo "<td style='text-align:center;'>$isi->WT12</td>";
                                            echo "<td style='text-align:center;'>$isi->CLS12</td>";
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;font-weight:600;'>$isi->COLUMN12</td>";
                                            $r++;
                                        }
                                        ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class='pull'>
                            <div class = 'legend legend-info'>
                                <strong>Formula : </strong> <strong>MTTR </strong>= Repair Time (RT) / &Sigma; Repair (&Sigma; R)
                            </div >
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>MTTR DIES SUB lINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe src="<?php echo site_url('mte/report_line_stop_c/chart_mttr_dies_by_line/' . $selected_date .'/'. $id_product_group ); ?>" height="300px" width="100%" style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->

         <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->
         <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>MTTR DIES GROUP LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe src="<?php echo site_url('mte/report_line_stop_c/chart_mttr_dies_by_product/' . $selected_date  ); ?>" height="300px" width="100%" style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
            $(document).ready(function () {
                    var table = $('#example').DataTable({
                        scrollY: "500px",
                        scrollX: true,
                        scrollCollapse: true,
                        paging: false,
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