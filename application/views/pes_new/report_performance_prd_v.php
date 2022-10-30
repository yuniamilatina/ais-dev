
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

    <section class="content">

        <div class="row">
            <div class="grid-body">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="<?php echo $monthly; ?>"><a href="#monthly" data-toggle="tab">Report Perfomance</a></li>
                    </ul>

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
                                                <th style="text-align: center;">Work Time (S)</th>
                                                <th style="text-align: center;">Line Stop (S)</th>
                                                <th style="text-align: center;">Total OK</th>
                                                <th style="text-align: center;">Total NG</th>
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
                                                    echo "<td style=text-align:center;>$isi->INT_WORK_TIME</td>";
                                                    echo "<td style=text-align:center;>$isi->SECOND_LINE_STOP</td>";
                                                    echo "<td style=text-align:center;>$isi->INT_TOTAL_QTY</td>";
                                                    echo "<td style=text-align:center;>$isi->INT_TOTAL_NG</td>";

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
<!-- </aside> -->
