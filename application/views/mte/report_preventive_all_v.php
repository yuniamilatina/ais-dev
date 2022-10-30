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
    .td-fixed-2{
        width: 90px;
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

<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>DATA PREVENTIVE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <?php 
                            $group_type = "";
                            if($group_line == 1){
                                $group_type = "MOLD";
                            } else if($group_line == 2){
                                $group_type = "DIES STP";
                            } else if($group_line == 3){
                                $group_type = "DIES DF";
                            } else if($group_line == 4){
                                $group_type = "MACHINE";
                            } else if($group_line == 5){
                                $group_type = "JIG";
                            }
                        ?>
                        <span class="grid-title"><strong>DATA PREVENTIVE - <?php echo $group_type; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="20%" id='filter' style="margin-bottom:-20px;">
                                <td>Filter</td>
                                <td style="vertical-align:top" width="10%">
                                    <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                        <?php foreach ($all_group_line as $row) { ?>
                                            <option value="<?php echo site_url('mte/report_preventive_c/report_preventive_all/' . $row->ID); ?>" <?php
                                            if ($group_line == $row->ID) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                <?php } ?>
                                    </select>
                                </td>                                
                            </table>
                        </div>
                        <br>
                        <div class="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tool Code</th>
                                        <th>Model</th>
                                        <th>Description</th>
                                        <th>Work Center</th>                                        
                                        <?php if($group_line == 4){ ?>
                                            <th>Preventive Hour</th>
                                            <th>Running Hour</th>
                                            <th>Remaining Hour</th>
                                        <?php } else { ?>
                                            <th>Preventive Stroke</th>
                                            <th>Running Stroke</th>
                                            <th>Remaining Stroke</th>
                                        <?php } ?>
                                        <th>Action</th> 

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($get_all_data_preventive_mte as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->code</td>";
                                        echo "<td>".trim($isi->model)."</td>";
                                        echo "<td>".trim($isi->name)."</td>";
                                        echo "<td align='center'>".trim($isi->work_center)."</td>";
                                        echo "<td align='right'>".str_replace(',','.', number_format($isi->stroke_big))."</td>";
                                        echo "<td align='right'>".str_replace(',','.', number_format($isi->stroke))."</td>";
                                        if ($isi->STATUS_DISPLAY == '1' || $isi->STATUS_DISPLAY == '4') {
                                            echo "<td align='right' style='background:yellow'>".str_replace(',','.', number_format(($isi->stroke_big - $isi->stroke)))."</td>";
                                        }
                                        else if ($isi->STATUS_DISPLAY == '2' || $isi->STATUS_DISPLAY == '5') {
                                            echo "<td align='right' style='background:red; color:white;'>".str_replace(',','.', number_format(($isi->stroke_big - $isi->stroke)))."</td>";
                                        }
                                        else if ($isi->STATUS_DISPLAY == '3' || $isi->STATUS_DISPLAY == '6') {
                                            echo "<td align='right' style='background:purple; color:white;'>".str_replace(',','.', number_format(($isi->stroke_big - $isi->stroke)))."</td>";
                                        } 
                                        else {
                                            echo "<td align='right'>".str_replace(',','.', number_format(($isi->stroke_big - $isi->stroke)))."</td>";
                                        }
                                        ?>
                                        <?php
                                        if ($isi->STATUS_DISPLAY == 0) { ?>                                         
                                            <td align="center"><a href="#" class="label label-default" data-placement="top" data-toggle="tooltip" title="Not yet">Done</span></a></td>                                                                          
                                        <?php } else { ?>
                                            <td align="center">
                                                <a href="<?php echo base_url('index.php/mte/preventive_schedule_c/update_flag_prev') . "/" . $isi->code; ?>" class="label label-success" data-placement="top" data-toggle="tooltip" title="Done"  onclick="return confirm('Are you really sure you have finished doing the preventive of this Part?');">Done</span></a>
                                            </td> 
                                        <?php } ?>

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
        </div>
    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                    sortable: false,
                    "class": "index",
                    targets: 0
                }],
            fixedColumns: {
                leftColumns: 3
            }
        });

        table.on('order.dt search.dt', function () {
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>