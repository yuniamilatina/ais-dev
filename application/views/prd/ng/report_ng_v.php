<script>
    $(document).ready(function () {
        var date = new Date();
        $("#datepicker1").datepicker({dateFormat: 'yymmdd'}).val();
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

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT NG NOTES</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT NG NOTES DAILY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid-body">
                    <?php echo form_open('prd/ng_c/index', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;" border=0px>
                                <tr>
                                    <td style="vertical-align:top" width=5%>
                                        <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo $date; ?>">
                                    </td>
                                    <td style="vertical-align:top" width=5%>
                                        <select id="work_center" name="CHR_WORK_CENTER" class="form-control" style="width:150px;">
                                            <option value="ALL" > ALL </option>
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
                                    <td style='vertical-align:top' width=5%>
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button></td>
                                        <?php form_close(); ?>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'NG Notes - '.$date)" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Category</th>
                                        <th style="text-align:center;">Qty NG</th>
                                        <th>Notes</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Created Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data as $isi) {

                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_NG_CATEGORY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_QTY_NG</td>";
                                        echo "<td>$isi->CHR_NOTES</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CREATED_BY</td>";
                                        echo "<td style=text-align:center;>".date("d-m-Y", strtotime($isi->CHR_CREATED_DATE))."</td>";
                                        echo "<td style=text-align:center;>".date("H:i:s", strtotime($isi->CHR_CREATED_TIME))."</td>";
                                        
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
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Category</th>
                                        <th style="text-align:center;">Qty NG</th>
                                        <th>Notes</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Created Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $r = 1;
                                    foreach ($data as $isi) {

                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_NG_CATEGORY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_QTY_NG</td>";
                                        echo "<td>$isi->CHR_NOTES</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CREATED_BY</td>";
                                        echo "<td style=text-align:center;>".date("d-m-Y", strtotime($isi->CHR_CREATED_DATE))."</td>";
                                        echo "<td style=text-align:center;>".date("H:i:s", strtotime($isi->CHR_CREATED_TIME))."</td>";
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT NG NOTES MONTHLY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid-body">
                    <?php echo form_open('prd/ng_c/index', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;" border=0px>
                                <tr>
                                    <td width=25%>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcelMonthly', 'NG Notes - '.$period)" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Category</th>
                                        <th style="text-align:center;">Qty NG</th>
                                        <th>Notes</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Created Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_monthly as $isi) {

                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_NG_CATEGORY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_QTY_NG</td>";
                                        echo "<td>$isi->CHR_NOTES</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CREATED_BY</td>";
                                        echo "<td style=text-align:center;>".date("d-m-Y", strtotime($isi->CHR_CREATED_DATE))."</td>";
                                        echo "<td style=text-align:center;>".date("H:i:s", strtotime($isi->CHR_CREATED_TIME))."</td>";
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcelMonthly" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Category</th>
                                        <th style="text-align:center;">Qty NG</th>
                                        <th>Notes</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Created Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $r = 1;
                                    foreach ($data_monthly as $isi) {

                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_NG_CATEGORY</td>";
                                        echo "<td style=text-align:center;>$isi->INT_QTY_NG</td>";
                                        echo "<td>$isi->CHR_NOTES</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_CREATED_BY</td>";
                                        echo "<td style=text-align:center;>".date("d-m-Y", strtotime($isi->CHR_CREATED_DATE))."</td>";
                                        echo "<td style=text-align:center;>".date("H:i:s", strtotime($isi->CHR_CREATED_TIME))."</td>";
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</aside>
