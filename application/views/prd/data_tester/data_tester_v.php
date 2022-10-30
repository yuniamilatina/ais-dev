<!-- <script>
    $(document).ready(function () {
        // var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
</script> -->

<script>
    $(function () {
    $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy', maxDate: 'today'});
    $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy', maxDate: 'today'});
    });
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
            <li><a href="#"><span><strong>Report Data Tester</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title"><strong>REPORT DATA TESTER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php echo form_open('prd/data_tester_c/search_data', 'class="form-horizontal"'); ?>
                    <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Start Date</td>
                                    <td width="5%">
                                        <input name="CHR_START_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo $start_date; ?>">
                                    </td>
                                    <td width="5%">End Date</td>
                                    <td width="5%">
                                        <input name="CHR_END_DATE" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo $end_date; ?>">
                                    </td>
                                    <td width="5%" style='text-align:left;'>
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="75%"></td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="75%" style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'DataTester')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                                </tr>
                            </table>
                            <?php form_close(); ?>
                        </div>
                        
                        <div id='table-luar'>
                            <table id="example2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" >No</th> 
                                        <th style="text-align:center;" >Prd Order No</th>
                                        <th style="text-align:center;" >Part No</th>
                                        <th style="text-align:center;" >Back No</th>
                                        <th style="text-align:center;" >Model</th>
                                        <th style="text-align:center;" >QR Code</th>
                                        <th style="text-align:center;" >Counter</th>
                                        <th style="text-align:center;" >Low K1 UPP</th>
                                        <th style='text-align:center;background-color:#beeef7' >Low K1</th>
                                        <th style="text-align:center;" >Low K1 LOW</th>
                                        <th style="text-align:center;" >Low H1 UPP</th>
                                        <th style='text-align:center;background-color:#d2f3e0' >Low H1</th>
                                        <th style="text-align:center;" >Low H1 LOW</th>
                                        <th style="text-align:center;" >High H1 UPP</th>
                                        <th style='text-align:center;background-color:#ffeead' >High H1</th>
                                        <th style="text-align:center;" >High H1 LOW</th>
                                        <th style="text-align:center;" >High H2 UPP</th>
                                        <th style='text-align:center;background-color:#beeef7' >High H2</th>
                                        <th style="text-align:center;" >High H2 LOW</th>
                                        <th style="text-align:center;" >High K1 UPP</th>
                                        <th style='text-align:center;background-color:#d2f3e0' >High K1</th>
                                        <th style="text-align:center;" >High K1 LOW</th>
                                        <th style="text-align:center;" >High K2 UPP</th>
                                        <th style='text-align:center;background-color:#ffeead' >High K2</th>
                                        <th style="text-align:center;" >High K2 LOW</th>
                                        <th style="text-align:center;" >High K3 UPP</th>
                                        <th style='text-align:center;background-color:#beeef7' >High K3</th>
                                        <th style="text-align:center;" >High K3 LOW</th>
                                        <th style="text-align:center;" >High K4 UPP</th>
                                        <th style='text-align:center;background-color:#d2f3e0' >High K4</th>
                                        <th style="text-align:center;" >High K4 LOW</th>
                                        <th style="text-align:center;" >Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data as $isi) {
                                        echo "<tr> ";
                                        echo "<td style='text-align:center;' >$isi->NOROW</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_PRD_ORDER_NO</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_PART_NO</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_BACK_NO</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_MODEL</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_BARCODE</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_COUNTER</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_K1_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#beeef7' >" . number_format($isi->CHR_LOW_K1/100,2,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_K1_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_H1_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#d2f3e0' >" . number_format($isi->CHR_LOW_H1/100,2,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_H1_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H1_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#ffeead' >" . number_format($isi->CHR_HIGH_H1/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H1_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H2_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#beeef7' >" . number_format($isi->CHR_HIGH_H2/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H2_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K1_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#d2f3e0' >" . number_format($isi->CHR_HIGH_K1/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K1_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K2_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#ffeead' >" . number_format($isi->CHR_HIGH_K2/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K2_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K3_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#beeef7' >" . number_format($isi->CHR_HIGH_K3/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K3_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K4_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:#d2f3e0' >" . number_format($isi->CHR_HIGH_K4/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K4_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_CREATED_DATE</td>"; 
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr> 
                                        <th style="text-align:center;" >No</th>
                                        <th style="text-align:center;" >Prd Order No</th>
                                        <th style="text-align:center;" >Part No</th>
                                        <th style="text-align:center;" >Back No</th>
                                        <th style="text-align:center;" >Model</th>
                                        <th style="text-align:center;" >QR Code</th>
                                        <th style="text-align:center;" >Counter</th>
                                        <th style='text-align:center;background-color:yellow' >Low K1 UPP</th>
                                        <th style='text-align:center;background-color:yellow' >Low K1</th>
                                        <th style='text-align:center;background-color:yellow' >Low K1 LOW</th>
                                        <th style="text-align:center;" >Low H1 UPP</th>
                                        <th style='text-align:center;' >Low H1</th>
                                        <th style="text-align:center;" >Low H1 LOW</th>
                                        <th style='text-align:center;background-color:yellow' >High H1 UPP</th>
                                        <th style='text-align:center;background-color:yellow' >High H1</th>
                                        <th style='text-align:center;background-color:yellow' >High H1 LOW</th>
                                        <th style="text-align:center;" >High H2 UPP</th>
                                        <th style='text-align:center;' >High H2</th>
                                        <th style="text-align:center;" >High H2 LOW</th>
                                        <th style='text-align:center;background-color:yellow' >High K1 UPP</th>
                                        <th style='text-align:center;background-color:yellow' >High K1</th>
                                        <th style='text-align:center;background-color:yellow' >High K1 LOW</th>
                                        <th style="text-align:center;" >High K2 UPP</th>
                                        <th style='text-align:center;' >High K2</th>
                                        <th style="text-align:center;" >High K2 LOW</th>
                                        <th style='text-align:center;background-color:yellow' >High K3 UPP</th>
                                        <th style='text-align:center;background-color:yellow' >High K3</th>
                                        <th style='text-align:center;background-color:yellow' >High K3 LOW</th>
                                        <th style="text-align:center;" >High K4 UPP</th>
                                        <th style='text-align:center;' >High K4</th>
                                        <th style="text-align:center;" >High K4 LOW</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data as $isi) {
                                        echo "<tr> ";
                                        echo "<td style='text-align:center;' >$isi->NOROW</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_PRD_ORDER_NO</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_PART_NO</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_BACK_NO</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_MODEL</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_BARCODE</td>";
                                        echo "<td style='text-align:center;' >$isi->CHR_COUNTER</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_LOW_K1_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_LOW_K1/100,2,',','.') . "</td>"; 
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_LOW_K1_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_H1_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_H1/100,2,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_LOW_H1_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_H1_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_H1/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_H1_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H2_UPP/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H2/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_H2_LOW/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_K1_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_K1/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_K1_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K2_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K2/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K2_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_K3_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_K3/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;background-color:yellow' >" . number_format($isi->CHR_HIGH_K3_LOW/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K4_UPP/1,0,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K4/10,1,',','.') . "</td>";
                                        echo "<td style='text-align:center;' >" . number_format($isi->CHR_HIGH_K4_LOW/1,0,',','.') . "</td>";
                                        echo "</tr>";
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
                                                var table = $('#example2').DataTable({
                                                    scrollY: "450px",
                                                    scrollX: true,
                                                    scrollCollapse: true,
                                                    paging: false,
                                                    bFilter: true,
                                                    fixedColumns: {
                                                        leftColumns: 3
                                                    }
                                                });
                                            });

</script>


