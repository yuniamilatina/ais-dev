
<script>
    $(function () {
    $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy', maxDate: 'today'});
    });
</script>

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
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Detail Generate Data Tester</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title"><strong>DETAIL GENERATE DATA TESTER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                            <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" >No</th> 
                                        <th style="text-align:center;" >Barcode</th>
                                        <th style="text-align:center;" >Prd Order No</th>
                                        <th style="text-align:center;" >TimeStamp</th>
                                        <th style="text-align:center;" >Flag Generated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr> ";
                                        echo "<td style='text-align:center;' >$i</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_BARCODE_PRODUCT</td>"; 
                                        echo "<td style='text-align:center;' >$isi->CHR_PRD_ORDER_NO</td>"; 
                                        echo "<td style='text-align:center;' >$isi->TIMESTAMP</td>"; 
                                        echo "<td style='text-align:center;' >$isi->INT_FLG_GENERATED</td>"; 
                                        echo "</tr>";
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

