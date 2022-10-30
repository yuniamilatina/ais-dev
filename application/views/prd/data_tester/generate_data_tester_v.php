
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
            <li><a href="#"><span><strong>Generate Data Tester</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title"><strong>GENERATE DATA TESTER</strong></span>
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
                                        <th style="text-align:center;" >Date</th>
                                        <th style="text-align:center;" >Flag Generated</th>
                                        <th style="text-align:center;" >Generated Timestamp</th>
                                        <th style="text-align:center;" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) { ?>
                                        <tr>
                                        <td style='text-align:center;'><?php echo $i; ?></td>

                                        <?php
                                        if ($isi->INT_FLG_GENERATED == '0') { ?>
                                            <td style='text-align:center;'><strong><a href="<?php echo base_url('/index.php/prd/data_tester_c/detail_generate_data_tester_by_date/').'/'.$isi->CHR_CREATED_DATE ?>"><?php echo $isi->CHR_CREATED_DATE; ?> </a></strong></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><?php echo $isi->CHR_CREATED_DATE; ?></td>
                                        <?php } ?>

                                        <td style='text-align:center;'><?php echo $isi->INT_FLG_GENERATED ?></td>

                                        <?php
                                        if ($isi->INT_FLG_GENERATED == '0') { ?>
                                            <td style='text-align:center;'><?php echo $isi->CHR_GENERATED; ?></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><strong><a href="<?php echo base_url('/index.php/prd/data_tester_c/detail_generate_data_tester_by_timestamp/').'/'.$isi->CHR_GENERATED ?>"><?php echo $isi->CHR_GENERATED; ?> </a></strong></td>
                                        <?php } ?>

                                        <td style='text-align:center;'>
                                        <?php
                                        if ($isi->INT_FLG_GENERATED == '0') { ?>
                                            <a href="<?php echo base_url('index.php/prd/data_tester_c/generate_data') . "/" . $isi->CHR_CREATED_DATE. "/" . $isi->INT_FLG_GENERATED; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Generate" ><span class="fa fa-upload"></span></a> 
                                            <!-- onclick="return confirm('Are you sure want to Generate this data tester with date : ' + <?php echo $isi->CHR_CREATED_DATE ?>);" -->
                                        <?php } else { ?>
                                            <a href="#" class="label label-default" data-placement="left" data-toggle="tooltip" title="Has been generated" ><span class="fa fa-info"></span></a>
                                        <?php } ?>
                                        </td>
                                        </tr>
                                        
                                    <?php $i++; }
                                    ?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</aside>

