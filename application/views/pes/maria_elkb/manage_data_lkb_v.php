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
<!-- <script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 10);
</script> -->

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
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/maria_elkb_c/"') ?>"><strong>Manage Data E-LKB</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>RESERVASI TROLLEY E-LKB</strong></span>
                       <div class="pull-right">
                            <a href="<?php echo base_url('index.php/pes/maria_elkb_c/create_rsv_elkb/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Create Data" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Create</a>
                        </div>
                    </div>                    

                    <div class="grid-body"  >
                        <?php echo form_open('pes/maria_elkb_c/history_coil_used', 'class="form-horizontal"'); ?>
                        <table width="100%" id='filter' border=0px style="margin-bottom: -10px;" >
                            <tr>
                                <td width="5%">Date from</td>
                                <td width="5%">
                                    <input name="CHR_DATE_FROM" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:130px;" value="<?php echo date("d-m-Y", strtotime($date_from)); ?>">
                                </td>
                                <td width="5%">to</td>
                                <td width="5%" style="text-align:right;">
                                    <input name="CHR_DATE_TO" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:130px;" value="<?php echo date("d-m-Y", strtotime($date_to)); ?>">
                                </td>
                                <td width="80%" >
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                </td>
                                <td width="30%" >
                                </td>
                            </tr>
                            <tr height="50">
                                <td width="5%">Trolly No</td>
                                <td width="15%">
                                    <select name="CHR_TROLL" id="e1" class="form-control" style="width:130px;">
                                        <option value="">- Pilih Trolly -</option>
                                        <?php
                                        foreach ($no_troll as $isi) {
                                            ?>
                                            <option value="<?php echo $isi->CHR_TROLLEY_ID; ?>"><?php echo $isi->CHR_TROLLEY_ID; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td width="60%" colspan="2">
                                </td>
                                <td width="20%" style="text-align:right;">
                                    <!-- <a href="<?php echo base_url("index.php/raw_material/coil_used_c/print_coil/X/$date_from/$date_to"); ?>" target="_blank" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Reprint" style="height:30px;font-size:13px;width:100px;color:#000000;">REPRINT ALL</a> -->
                                </td>
                                <td>
                                    <!-- <input type="button" onclick="tableToExcel('dataTables3', 'W3C Example Table')" value="Expor to Excel" class="btn btn-primary"> -->
                                </td>
                            </tr>
                        </table>
                        <?php form_close(); ?>

                        <div id="table-luar">
                            <table id="example1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>E-LKB No</th>
                                        <th style='text-align:center;'>Trolley ID</th>
                                        <th style='text-align:center;'>Description</th>
                                        <th style='text-align:center;'>Create D/T</th>                                        
                                        <th style='text-align:center;'>Create By</th>
                                        <th style='text-align:center;'>Status Finish</th>
                                        <th style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($rsvr_troll as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_ID_ELKB</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_TROLLEY_ID</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_DESC</td>";
                                        echo "<td style='text-align:center;'>".date("d-M-Y", strtotime($isi->CHR_DATE_CREATE))." / ".date("H:i", strtotime($isi->CHR_TIME_CREATE))."</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_NPK_CREATE</td>";
                                        if($isi->CHR_STAT_FINISH=='T'){ ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                        <?php }
                                        ?>
                                    <td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/pes/maria_elkb_c/edit_dt_trolley') . "/" . $isi->CHR_ID_ELKB; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Tambah part"><span class="fa fa-pencil"></span></a>
                                        <!--<a href="<?php echo base_url('index.php/pes/part_per_line_c/delete_target_production') . "/" . $isi->CHR_PART_NO . "/" . $isi->CHR_BACK_NO; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this data?');"><span class="fa fa-times"></span></a>-->
                                    </td>
                                    </tr>
                                    <?php
                                    $r++;
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