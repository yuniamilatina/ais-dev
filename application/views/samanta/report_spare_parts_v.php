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
            <li><a href=""><strong>REPORT IN OUT TOOLS</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT OUT TOOLS</strong></span>
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
                                                <option value="<?php echo site_url('samanta/report_spare_parts_c/report_spare_parts/' . date("Ym", strtotime("+$y day")) . '/' . $group_line); ?>" <?php
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
                                            <?php foreach ($all_group_line as $row) { ?>
                                                <option value="<?php echo site_url('samanta/report_spare_parts_c/report_spare_parts/' . $selected_date . '/' . $row->ID); ?>" <?php
                                                if ($group_line == $row->ID) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_GROUP_LINE); ?></option>
                                                    <?php } ?>
                                        </select>

                                    </td>                                  
                                    <td width="75%" style="text-align:right;">
                                    <?php echo form_open('#', 'class="form-horizontal"'); ?>
                                        <input type='hidden' name='CHR_DATE_SELECTED' value='<?php echo $selected_date ?>'>
                                        <input type='hidden' name='GROUP_LINE' value='<?php echo $group_line ?>'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Summary Line Stop')" value="Export to Excel" style="margin-bottom: 20px;">
                                        <!-- <input type="submit" class="btn btn-primary"  value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input> -->
                                    <?php echo form_close(); ?>
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Part No</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Part Name</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Out to</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Total</th>                                        
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Amount</th>

                                        <th colspan='31' style="text-align:center;">Date</th>
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
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_transaction_out as $isi) {
                                            echo "<tr style=text-align:center;>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                            echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_LOCATION_TO</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->INT_OUT_TOTAL_QTY)) . "</td>";
                                            echo "<td style=text-align:right;>" . str_replace(',','.',number_format($isi->TOTAL_AMOUNT)) . "</td>";

                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_01)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_02)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_03)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_04)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_05)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_06)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_07)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_08)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_09)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_10)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_11)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_12)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_13)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_14)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_15)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_16)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_17)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_18)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_19)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_20)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_21)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_22)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_23)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_24)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_25)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_26)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_27)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_28)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_29)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_30)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_31)). "</div></td>";
                                            
                                           ?>
                                            </tr>
                                            <?php
                                            $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered  display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part Name</th>
                                        <th rowspan="2" style="vertical-align: middle;">Out to</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Total</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Amount</th>

                                        <th colspan='31' style="text-align:center;">Date</th>
                                        
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
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_transaction_out as $isi) {
                                            echo "<tr style=text-align:center;>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                            echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_LOCATION_TO</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->INT_OUT_TOTAL_QTY)) . "</td>";
                                            echo "<td style=text-align:right;>" . str_replace(',','.',number_format($isi->TOTAL_AMOUNT)) . "</td>";

                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_01)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_02)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_03)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_04)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_05)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_06)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_07)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_08)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_09)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_10)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_11)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_12)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_13)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_14)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_15)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_16)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_17)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_18)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_19)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_20)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_21)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_22)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_23)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_24)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_25)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_26)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_27)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_28)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_29)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_30)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->OUT_31)). "</div></td>";
                                            
                                           ?>
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

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT IN TOOLS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>                                  
                                    <td width="75%" style="text-align:right;">
                                    <?php echo form_open('#', 'class="form-horizontal"'); ?>
                                        <input type='hidden' name='CHR_DATE_SELECTED' value='<?php echo $selected_date ?>'>
                                        <input type='hidden' name='GROUP_LINE' value='<?php echo $group_line ?>'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Summary Line Stop')" value="Export to Excel" style="margin-bottom: 20px;">
                                        <!-- <input type="submit" class="btn btn-primary"  value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input> -->
                                    <?php echo form_close(); ?>
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part Name</th>
                                        <th rowspan="2" style="vertical-align: middle;">Out to</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Total</th>

                                        <th colspan='31' style="text-align:center;">Date</th>
                                        
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
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_transaction_in as $isi) {
                                            echo "<tr style=text-align:center;>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                            echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_LOCATION_TO</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->INT_IN_TOTAL_QTY)) . "</td>";

                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_01)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_02)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_03)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_04)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_05)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_06)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_07)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_08)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_09)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_10)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_11)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_12)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_13)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_14)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_15)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_16)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_17)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_18)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_19)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_20)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_21)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_22)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_23)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_24)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_25)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_26)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_27)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_28)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_29)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_30)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_31)). "</div></td>";
                                            
                                           ?>
                                            </tr>
                                            <?php
                                            $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel2" class="table table-condensed table-bordered  display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part No</th>
                                        <th rowspan="2" style="vertical-align: middle;">Part Name</th>
                                        <th rowspan="2" style="vertical-align: middle;">Out to</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Total</th>

                                        <th colspan='31' style="text-align:center;">Date</th>
                                        
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
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_transaction_in as $isi) {
                                            echo "<tr style=text-align:center;>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                                            echo "<td style=text-align:left;>$isi->CHR_PART_NAME</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_LOCATION_TO</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->INT_IN_TOTAL_QTY)) . "</td>";

                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_01)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_02)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_03)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_04)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_05)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_06)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_07)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_08)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_09)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_10)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_11)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_12)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_13)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_14)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_15)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_16)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_17)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_18)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_19)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_20)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_21)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_22)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_23)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_24)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_25)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_26)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_27)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_28)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_29)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_30)). "</div></td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'><div class='td-fixed'>" . str_replace(',','.',number_format($isi->IN_31)). "</div></td>";
                                            
                                           ?>
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
                leftColumns: 5
            }
        });

        table.on('order.dt search.dt', function () {
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();
    });

    $(document).ready(function () {
        var table = $('#example2').DataTable({
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
                leftColumns: 5
            }
        });

        table.on('order.dt search.dt', function () {
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>