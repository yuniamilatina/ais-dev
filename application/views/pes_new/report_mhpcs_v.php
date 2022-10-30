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

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PROD PER HOUR MP</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PROD PER HOUR MP </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="vertical-align:top" width="5%">Periode</td>
                                    <td style="vertical-align:top" width="10%">
                                        <select class="ddl2" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> 
                                                </option>
                                                    <?php } ?>

                                            <!-- <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201804' . '/' . $id_prod); ?>" <?php if ($selected_date == '201804') { echo 'SELECTED'; } ?> > 201804 </option>
                                            <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201805' . '/' . $id_prod); ?>" <?php if ($selected_date == '201805') { echo 'SELECTED'; } ?> > 201805 </option>
                                            <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201806' . '/' . $id_prod); ?>" <?php if ($selected_date == '201806') { echo 'SELECTED'; } ?> > 201806 </option>
                                            <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201807' . '/' . $id_prod); ?>" <?php if ($selected_date == '201807') { echo 'SELECTED'; } ?> > 201807 </option>
                                            <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201808' . '/' . $id_prod); ?>" <?php if ($selected_date == '201808') { echo 'SELECTED'; } ?> > 201808 </option>
                                            <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201809' . '/' . $id_prod); ?>" <?php if ($selected_date == '201809') { echo 'SELECTED'; } ?> > 201809 </option>
                                            <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/201810' . '/' . $id_prod); ?>" <?php if ($selected_date == '201810') { echo 'SELECTED'; } ?> > 201810 </option> -->
                                        </select>
                                    </td>
                                    <td style="vertical-align:top" width="10%">
                                            <?php if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 ) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<?php echo site_url('pes_new/report_mhpcs_c/search_prod_entry/' . $selected_date . '/' . $row->INT_ID_DEPT); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>Work Center</strong></th>
                                        <th colspan='31' style="text-align:center;">Date </th>
                                        <th rowspan="2" style='background:#007FFF;color:#FFFFFF;vertical-align: middle;'>Total </th>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        $date = new DateTime($first_saturday);
                                        $thisMonth = $date->format('m');

                                        $z = 0;
                                        while ($date->format('m') === $thisMonth) {
                                            $datesaturday[$z] = $date->format('j');
                                            $date->modify('next Saturday');
                                            $z++;
                                        }

                                        $date1 = new DateTime($first_sunday);
                                        $thisMonth1 = $date1->format('m');

                                        $y = 0;
                                        while ($date1->format('m') === $thisMonth1) {
                                            $datesunday[$y] = $date1->format('j');
                                            $date1->modify('next Sunday');
                                            $y++;
                                        }

                                        $k = 0;
                                        for ($a = 1; $a <= 31; $a++) {
                                            if ($y == 5 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <!-- <tr class='gradeX'>
                                        <?php
                                        // for ($x = 1; $x <= 31; $x++) {
                                        //     if ($x % 2 != 0) {
                                        //         echo "<td style='text-align:center;background:#03C03C;color:white;'><div class='td-fixed'>OK</div></td>";
                                        //     } else {
                                        //         echo "<td style='text-align:center;background:#E34234;color:white;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                        //     }
                                        // }
                                        ?>
                                    </tr> -->
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_prod_per_hour_per_mp as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;><strong>$isi->CHR_WORK_CENTER</strong></td>";
                                        
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->DATE_31) . "</td>";
                                        echo "<td style='background:#007FFF;color:#FFFFFF;text-align:center;border-right-width: 0.1em;'>" . str_replace('.',',',$isi->TOTAL) . "</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class='pull'>
                            <div class = 'legend legend-info'>
                                <strong>Formula : </strong> Total OK / (Work Time - Bridging) / Average of MP 
                            </div >
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
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 2
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                });

</script>