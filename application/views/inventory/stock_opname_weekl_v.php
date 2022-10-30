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
                                    setTimeout(function(){ 
                                        $("#hide-sub-menus").click();
    }, 1000);
                                                                    

</script>



<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/inventory/weekly_sto/'); ?>"><span><strong>Report STO Weekly</strong></span></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-cube"></i>
                        <span class="grid-title"><strong>REPORT STOCK OPNAME WEEKLY</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('inventory/stock_opname_c/weekly_sto', 'class="form-horizontal"'); ?>
                        <table width="100%" id='filter' border=0px style="margin-bottom: 50px;">
                            <tr>
                                <td width="7%">Date from</td>
                                <td width="15%">
                                    <input name="CHR_DATE_FROM" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo date("d-m-Y", strtotime($date_from)); ?>">
                                </td>
                                <td width="1%"></td>
                                <td width="3%">to</td>
                                <td width="15%" style="text-align:right;">
                                    <input name="CHR_DATE_TO" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:240px;" value="<?php echo date("d-m-Y", strtotime($date_to)); ?>">
                                </td>
                                <td width="50%" ></td>
                            </tr>
                            <tr height="50">
                                <td width="80%" colspan="4"></td>
                                <td width="20%" style="text-align:right;">
                                    <button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    <input type="button" onclick="tableToExcel('dataTables1', 'W3C Example Table')" value="Expor to Excel" class="btn btn-primary">
                                </td>
                            </tr>
                        </table>
                        <?php form_close(); ?>
                        <table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center;" rowspan="2">No </th>
                                    <th style="text-align:center;" rowspan="2">Back. No </th>
                                    <th style="text-align:center;" rowspan="2">Part. No </th>
                                    <th style="text-align:center;" rowspan="2">Part.Name & Model </th>
                                    <th style="text-align:center;" rowspan="2">Sloc.</th>
                                    <th style="text-align:center;" rowspan="2">Qty </th> 
                                    <th style="text-align:center;" rowspan="2">Box </th>
                                    <th style="text-align:center;" rowspan="2">Total Qty </th>
                                    <th style="text-align:center;" rowspan="2">Uom</th>
                                    <th style="text-align:center;" rowspan="2">Sub Area </th>
                                    <th style="text-align:center;" rowspan="2">Chute </th>
                                    <th style="text-align:center;" colspan="2">Scan </th>
                                </tr>

                                <tr>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Time</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_sto as $isi) {
                                    echo "<td style='text-align: center;'>$i</td>";
                                    echo "<td style='text-align: center;'>$isi->B_No</td>";
                                    echo "<td style='text-align: center;'>$isi->P_No</td>";
                                    echo "<td style='text-align: center;'>$isi->P_Name</td>";
                                    echo "<td style='text-align: center;'>$isi->S_Location</td>";
                                    echo "<td style='text-align: center;'>$isi->Qty</td>";
                                    echo "<td style='text-align: center;'>$isi->Multiplier</td>";
                                    echo "<td style='text-align: center;'>" . number_format($isi->Qty * $isi->Multiplier) . "</td>";
                                    echo "<td style='text-align: center;'>PC</td>";
                                    echo "<td style='text-align: center;'>$isi->SUBAREA</td>";
                                    echo "<td style='text-align: center;'>$isi->Chute</td>";
                                    echo "<td style='text-align: center;'>" . date("d-M-Y", strtotime($isi->Tgl)) . "</td>";
                                    echo "<td style='text-align: center;'>" . date("H:i:s", strtotime($isi->Waktu)) . "</td>";
                                    ?>

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

    </section>
</aside>