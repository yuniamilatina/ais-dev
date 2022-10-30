<style type="text/css">
    [class='xx'] {
        display: none;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 5px;
    }
    .td-fixed{
        width: 10px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    .filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }

    .btnt{
        border:none;
    }

    .btnt:focus{
        outline: none;
    }

    .btnt:hover {
        background: #428bca;
        background-image: -webkit-linear-gradient(top, #428bca, #428bca);
        background-image: -moz-linear-gradient(top, #428bca, #428bca);
        background-image: -ms-linear-gradient(top, #428bca, #428bca);
        background-image: -o-linear-gradient(top, #428bca, #428bca);
        background-image: linear-gradient(to bottom, #428bca, #428bca);
        color:white;
    }
</style>

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
</script>

<script>     
var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,', template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
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
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_c') ?>">Manage Spare Part</a></li>
            <li> <a href="#"><strong>List Order</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-laptop"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">SUMMARY</strong> ORDER LIST SPARE PART</span>
                        <div class="pull-right grid-tools" style="font-size:11px;" >
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull-right">
                            <tr>
                                <td width="90%">
                                    <!-- <input type="button" onclick="tableToExcel('exportToExcel_qty', 'W3C Example Table')" value="Export to Excel" class="btn btn-success fa fa-file-excel-o"> -->
                                    <?php echo anchor('samanta/spare_parts_c/list_order', 'Cancel', 'class="btn btn-default"'); ?>&nbsp;
                                    <?php echo anchor('samanta/spare_parts_c/save_order_list', 'Save Data', 'class="btn btn-primary"'); ?>
                                    &nbsp;<button onclick="tableToExcel('exportToExcel_qty', 'W3C Example Table')" title="Export Order List" class="btn btn-success" style="font-size:12px;"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Export to Excel</button>
                                </td>
                            </tr>
                        </div>
                        <table class="table table-condensed table-bordered table-striped table-hover display" id="list_data">
                            <thead>
                                <tr style="font-weight:bold; font-size:12px">
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">No</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Part No</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Spare Part Name</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Specification</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Component</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Model</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Qty Use</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Qty Min</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Qty Max</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Stock</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align:center;">Total Out</th>
                                    <th colspan="2" style="vertical-align: middle; text-align:center;">Order</th>
                                </tr>
                                <tr style="font-weight:bold; font-size:12px">
                                    <td align='center' style="vertical-align: middle;">Qty</td>
                                    <td align='center' style="vertical-align: middle;">Amount</td>
                                </tr>
                            </thead>

                            <tbody> 
                            <?php $i = 1;
                                foreach ($data_part_order as $datatable) {
                                echo "<tr>";
                                    echo "<td style='text-align:center'>$i</td>";
                                    ?>
                                    <input type="hidden" name="part_no[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PART_NO; ?>" /> 
                                    <input type="text" class="xx" name="price[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PRICE; ?>" />
                                    <?php
                                    echo "<td style='text-align:center'>$datatable->CHR_PART_NO</td>";
                                    echo "<td>". substr($datatable->CHR_SPARE_PART_NAME,0,20) . "</td>";
                                    echo "<td>$datatable->CHR_SPECIFICATION</td>";
                                    echo "<td style='text-align:center'>$datatable->CHR_COMPONENT</td>";
                                    echo "<td style='text-align:center'>$datatable->CHR_MODEL</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_USE</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_MIN</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_MAX</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_ACT</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_OUT</td>";
                                    echo "<td style='text-align:center'>$datatable->INT_QTY_ORDER</td>"; ?>
                                    <td style='text-align:right'>Rp&nbsp;<?php  $amount = (int)$datatable->CHR_AMOUNT;
                                        echo number_format($amount, 0, ',', '.'); ?></td>
                                </tr>
                                <?php
                                $i++; }
                            ?>
                                <tr>
                                    <td colspan="11" style="text-align:right"><strong>TOTAL&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                    <td style="text-align:center;"><strong><?php echo number_format($total_qty, 0, ',', '.'); ?></strong></td>
                                    <td style="text-align:right"><strong>Rp&nbsp;<?php echo number_format($total_amount, 0, ',', '.'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pull">
                            <table id="exportToExcel_qty" class="table table-condensed table-bordered table-striped table-hover display" border-color="black" width="100%" style="display:none;">
                                <thead>
                                    <tr style="font-weight:bold; font-size:26px">
                                        <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center;"></th>
                                        <th rowspan="2" colspan="9" style="vertical-align: middle; text-align:center;">LIST ORDER SPARE PARTS PT AISIN INDONESIA</th>
                                        <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center;"></th>
                                    <tr>
                                    <tr style="font-weight:bold; font-size:14px;">
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">No</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Aii Spare Part No</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Spare Part Name</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Specification</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Component</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Model</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Qty Use (pcs)</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Qty Min (pcs)</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Qty Max (pcs)</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Actual Stock</th>
                                        <th rowspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Total Out</th>
                                        <th colspan="2" style="color:white; vertical-align: middle; text-align:center; background-color:#4286f4">Order</th>
                                    </tr>
                                    <tr style="font-weight:bold; font-size:14px;">
                                        <td align='center' style="color:white; vertical-align: middle; background-color:#4286f4">Qty (pcs)</td>
                                        <td align='center' style="color:white; vertical-align: middle; background-color:#4286f4">Amount</td>
                                    </tr>
                                </thead>

                                <tbody> 
                                <?php $i = 1;
                                    foreach ($data_part_order as $datatable) {
                                    echo "<tr>";
                                        echo "<td style='text-align:center'>$i</td>";
                                        ?>
                                        <input type="hidden" name="part_no[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PART_NO; ?>" /> 
                                        <input type="text" class="xx" name="price[<?php echo $i; ?>]" value="<?php echo $datatable->CHR_PRICE; ?>" />
                                        <?php
                                        echo "<td style='text-align:center'>$datatable->CHR_PART_NO</td>";
                                        echo "<td>". substr($datatable->CHR_SPARE_PART_NAME,0,20) . "</td>";
                                        echo "<td>$datatable->CHR_SPECIFICATION</td>";
                                        echo "<td style='text-align:center'>$datatable->CHR_COMPONENT</td>";
                                        echo "<td style='text-align:center'>$datatable->CHR_MODEL</td>";
                                        echo "<td style='text-align:center'>$datatable->INT_QTY_USE</td>";
                                        echo "<td style='text-align:center'>$datatable->INT_QTY_MIN</td>";
                                        echo "<td style='text-align:center'>$datatable->INT_QTY_MAX</td>";
                                        echo "<td style='text-align:center'>$datatable->INT_QTY_ACT</td>";
                                        echo "<td style='text-align:center'>$datatable->INT_QTY_OUT</td>";
                                        echo "<td style='text-align:center'>$datatable->INT_QTY_ORDER</td>"; ?>
                                        <td style='text-align:right'>Rp&nbsp;<?php  $amount = (int)$datatable->CHR_AMOUNT;
                                            echo number_format($amount, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php
                                    $i++; }
                                ?>
                                    <tr style="font-weight:bold; font-size:14px;">
                                        <td colspan="11" style="text-align:right; background-color:#fffc9e;"><strong>TOTAL&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                        <td style="text-align:center; background-color:#fffc9e;"><strong><?php echo number_format($total_qty, 0, ',', '.'); ?></strong></td>
                                        <td style="text-align:right; background-color:#fffc9e;"><strong>Rp&nbsp;<?php echo number_format($total_amount, 0, ',', '.'); ?></strong></td>
                                    </tr>
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