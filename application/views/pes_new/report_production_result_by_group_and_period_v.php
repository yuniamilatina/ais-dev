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

<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 25);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION RESULT</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION RESULT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="vertical-align:top" width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -20; $x <= 0; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('pes_new/production_result_c/report_prod_result/' . date("Ym", strtotime("+$y day")) . '/' . $id_product_group); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> 
                                                </option>
                                                    <?php } ?>

                                        </select>
                                    </td>
                                    <td style="vertical-align:top" width="10%">
                                            <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php foreach ($all_product_group as $row) { ?>
                                                    <option value="<?php echo site_url('pes_new/production_result_c/report_prod_result/' . $selected_date . '/' . $row->INT_ID); ?>" <?php
                                                    if ($id_product_group == $row->INT_ID) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_PRODUCT_GROUP); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                    <?php echo form_open('pes_new/production_result_c/download_report_prod_result', 'class="form-horizontal"'); ?>
                                        <input type='hidden' name='CHR_DATE_SELECTED' value='<?php echo $selected_date ?>'>
                                        <input type='hidden' name='INT_GROUP_PROD' value='<?php echo $id_product_group ?>'>
                                        <input type="submit" class="btn btn-primary"  value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input>
                                    <?php echo form_close(); ?>
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Back No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Part Name</th>
                                        <th rowspan="3" style="vertical-align: middle;">Target <br> Plan</th>
                                        <th rowspan="3" style="vertical-align: middle;">Total <br> Actual</th>

                                        <th colspan='62' style="text-align:center;">Date </th>
                                        
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
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 62; $x++) {
                                            if ($x % 2 != 0) {
                                                echo "<td style='text-align:center;background:#3BB269;color:#069A3B;border-left-width: 0.1em;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E83941;color:#B51C22;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 0;
                                    $total = 0;
                                    foreach ($data_production_result as $isi) {
                                            $r++;
                                            $total = $isi->OK_01 + $isi->OK_02 + $isi->OK_03 + $isi->OK_04 + $isi->OK_05 + $isi->OK_06 + $isi->OK_07 + $isi->OK_08 + $isi->OK_09 + $isi->OK_10 +
                                            $isi->OK_11 + $isi->OK_12 + $isi->OK_13 + $isi->OK_14 + $isi->OK_15 + $isi->OK_16 + $isi->OK_17 + $isi->OK_18 + $isi->OK_19 + $isi->OK_20 +
                                            $isi->OK_21 + $isi->OK_22 + $isi->OK_23 + $isi->OK_24 + $isi->OK_25 + $isi->OK_26 + $isi->OK_27 + $isi->OK_28 + $isi->OK_29 + $isi->OK_30 + $isi->OK_31;

                                            echo "<tr style=text-align:center; >";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                            echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_BACK_NO</td>";
                                            echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                            echo "<td style=text-align:center;>$isi->INT_TARGET_PRODUCTION</td>";
                                            echo "<td style=text-align:center;>$total</td>";

                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            echo "<td style='text-align:center;'>". str_replace(',','.',number_format($isi->NG_01)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";
                                            
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
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
                                                $(document).ready(function () {

                                                    var table = $('#example').DataTable({
                                                        scrollY: "500px",
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