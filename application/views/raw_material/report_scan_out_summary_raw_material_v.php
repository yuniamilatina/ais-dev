<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
</script>

<script>
    $(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
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

<style type="text/css">
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 5px;
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
            <li><a href=""><strong>REPORT SCAN OUT SUMMARY RAW MATERIAL</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>SCAN OUT SUMMARY RAW MATERIAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('raw_material/scan_out_c/summary', 'class="form-horizontal"'); ?> 
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="2%">From</td>
                                    <td width="15%">
                                        <div class="input-group date form_date" >
                                            <input type="text" class="form-control date-picker" id="datepicker" name="start_date" value="<?php echo $start_date; ?>">
                                        </div>
                                    </td>
                                    <td width="2%">To</td>
                                    <td width="15%">
                                        <div class="input-group date form_date" >
                                            <input type="text" class="form-control date-picker" id="datepicker1" name="finish_date" value="<?php echo $finish_date; ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" name="btn_submit" id="btn_submit" value="1" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Search" style="height:35px;width:100px;"><i class="fa fa-search"></i>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td style="text-align:right;padding-top:10px;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input>
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>

                        </div>
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                <th>No</th>
                                <th>Date</th>
                                <th>Part No</th>
                                <th>Back No</th>
                                <th>Part Name</th>
                                <th>SLOC From</th>
                                <th>SLOC To</th>
                                <th>Total Qty</th>
                                <th>Total Kanban</th>
                                </thead> 
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data_scan_out as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo date("d-M-Y", strtotime($data->CHR_DATE)) ?></td>
                                            <td><?php echo $data->CHR_PART_NO ?></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_BACK_NO ?></div></td>
                                            <td><?php echo $data->CHR_PART_NAME; ?></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_SLOC_FROM; ?></div></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_SLOC_TO; ?></div></td>
                                            <td><?php echo $data->INT_TOTAL_QTY; ?></td>
                                            <td><?php echo $data->INT_QTY_BOX; ?></td>
                                            <?PHP
                                            $no++;
                                        }
                                        ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                <th>No</th>
                                <th>Date</th>
                                <th>Part No</th>
                                <th>Back No</th>
                                <th>Part Name</th>
                                <th>SLOC From</th>
                                <th>SLOC To</th>
                                <th>Total Qty</th>
                                <th>Total Kanban</th>
                                </thead> 
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data_scan_out as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo date("d-M-Y", strtotime($data->CHR_DATE)) ?></td>
                                            <td><?php echo $data->CHR_PART_NO ?></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_BACK_NO ?></div></td>
                                            <td><?php echo $data->CHR_PART_NAME; ?></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_SLOC_FROM; ?></div></td>
                                            <td><div class='td-fixed'><?php echo $data->CHR_SLOC_TO; ?></div></td>
                                            <td><?php echo $data->INT_TOTAL_QTY; ?></td>
                                            <td><?php echo $data->INT_QTY_BOX; ?></td>
                                            <?PHP
                                            $no++;
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






