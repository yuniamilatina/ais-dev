<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<script>
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>

<script>
    setTimeout(function() {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT REJECT IN LINE</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT REJECT IN LINE </strong></span>
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
                                            <?php for ($x = -15; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('pes_new/report_reject_in_line_c/filter_by/' . date("Ym", strtotime("+$y day")) . '/' . $id_product_group); ?>" <?php
                                                                                                                                                                                                    if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$y day")); ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </td>
                                    <td style="vertical-align:top" width="10%">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_product_group as $row) { ?>
                                                <option value="<?php echo site_url('pes_new/report_reject_in_line_c/filter_by/' . $selected_date . '/' . $row->INT_ID); ?>" <?php
                                                                                                                                                                            if ($id_product_group == $row->INT_ID) {
                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                            }
                                                                                                                                                                            ?>><?php echo trim($row->CHR_PRODUCT_GROUP); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>

                                        <th colspan='3' style="text-align:center;">Ratio RIL</th>

                                        <th rowspan="3" style="vertical-align: middle;">Total OK</th>
                                        <th rowspan="3" style="vertical-align: middle;">Total RIL</th>
                                        <th rowspan="3" style="vertical-align: middle;">Grand Total</th>

                                        <th colspan='4' style="text-align:center;">Detail RIL </th>

                                        <th colspan='62' style="text-align:center;">Date </th>

                                    </tr>
                                    <tr class='gradeX'>

                                        <th rowspan="2" style="vertical-align: middle;background:whitesmoke;">Qty YTD</th>
                                        <th rowspan="2" style="vertical-align: middle;background:whitesmoke;">Qty (n-1)</th>
                                        <th rowspan="2" style="vertical-align: middle;background:whitesmoke;">Amount</th>

                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">Process</th>
                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">B.test</th>
                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">Trial</th>
                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">Setup</th>

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
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
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
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-right: 1px solid #cdd0d4;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_reject_in_line as $isi) {

                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 10) {

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL >= 0.1) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL >= 0.5) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.1) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.5) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            echo "<tr style=text-align:center; >";
                                            echo "<td style=text-align:center;><strong></strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL) . "</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL_BEFORE) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.', ',', $isi->CHR_RATIO_AMOUNT_RIL) . "</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_PR)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_BT)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_TR)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_SU)) . "</strong></td>";



                                            if ($isi->OK_01 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                            } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_01)) . "</td>";

                                            if ($isi->OK_02 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                            } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_02)) . "</td>";

                                            if ($isi->OK_03 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                            } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_03)) . "</td>";

                                            if ($isi->OK_04 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                            } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_04)) . "</td>";

                                            if ($isi->OK_05 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                            } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_05)) . "</td>";

                                            if ($isi->OK_06 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                            } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_06)) . "</td>";

                                            if ($isi->OK_07 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                            } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_07)) . "</td>";

                                            if ($isi->OK_08 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                            } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_08)) . "</td>";

                                            if ($isi->OK_09 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                            } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_09)) . "</td>";

                                            if ($isi->OK_10 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                            } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_10)) . "</td>";

                                            if ($isi->OK_11 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                            } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_11)) . "</td>";

                                            if ($isi->OK_12 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                            } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_12)) . "</td>";

                                            if ($isi->OK_13 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                            } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_13)) . "</td>";

                                            if ($isi->OK_14 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                            } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_14)) . "</td>";

                                            if ($isi->OK_15 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                            } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_15)) . "</td>";

                                            if ($isi->OK_16 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                            } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_16)) . "</td>";

                                            if ($isi->OK_17 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                            } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_17)) . "</td>";

                                            if ($isi->OK_18 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                            } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_18)) . "</td>";

                                            if ($isi->OK_19 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                            } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_19)) . "</td>";

                                            if ($isi->OK_20 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                            } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_20)) . "</td>";

                                            if ($isi->OK_21 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                            } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_21)) . "</td>";

                                            if ($isi->OK_22 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                            } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_22)) . "</td>";

                                            if ($isi->OK_23 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                            } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_23)) . "</td>";

                                            if ($isi->OK_24 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                            } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_24)) . "</td>";

                                            if ($isi->OK_25 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                            } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_25)) . "</td>";

                                            if ($isi->OK_26 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                            } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_26)) . "</td>";

                                            if ($isi->OK_27 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                            } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_27)) . "</td>";

                                            if ($isi->OK_28 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                            } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_28)) . "</td>";

                                            if ($isi->OK_29 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                            } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_29)) . "</td>";

                                            if ($isi->OK_30 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                            } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_30)) . "</td>";

                                            if ($isi->OK_31 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                            } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',', '.', number_format($isi->NG_31)) . "</td>";


                                    ?>
                                            </tr>
                                        <?php
                                        } else if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL >= 0.1) {
                                                    $color = 'background:#C42820;color:white;';
                                                } else {
                                                    $color = 'background:#0FA819;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL >= 0.5) {
                                                    $color = 'background:#C42820;color:white;';
                                                } else {
                                                    $color = 'background:#0FA819;color:white;';
                                                }
                                            }

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.1) {
                                                    $color_before = 'background:#C42820;color:white;';
                                                } else {
                                                    $color_before = 'background:#0FA819;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.5) {
                                                    $color_before = 'background:#C42820;color:white;';
                                                } else {
                                                    $color_before = 'background:#0FA819;color:white;';
                                                }
                                            }

                                            echo "<tr>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong></strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL) . " %</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL_BEFORE) . " %</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace('.', ',', $isi->CHR_RATIO_AMOUNT_RIL) . " %</strong></td>";

                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</strong></td>";

                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',', '.', number_format($isi->TOTAL_PR)) . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',', '.', number_format($isi->TOTAL_BT)) . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',', '.', number_format($isi->TOTAL_TR)) . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',', '.', number_format($isi->TOTAL_SU)) . "</td>";

                                            // if ($isi->OK_01 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                            //}
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_01)) . "</td>";

                                            // if ($isi->OK_02 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_02)) . "</td>";

                                            // if ($isi->OK_03 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_03)) . "</td>";

                                            // if ($isi->OK_04 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_04)) . "</td>";

                                            // if ($isi->OK_05 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_05)) . "</td>";

                                            // if ($isi->OK_06 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_06)) . "</td>";

                                            // if ($isi->OK_07 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                            // } 
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_07)) . "</td>";

                                            // if ($isi->OK_08 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_08)) . "</td>";

                                            // if ($isi->OK_09 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                            // } 
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_09)) . "</td>";

                                            // if ($isi->OK_10 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_10)) . "</td>";

                                            // if ($isi->OK_11 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_11)) . "</td>";

                                            // if ($isi->OK_12 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_12)) . "</td>";

                                            // if ($isi->OK_13 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_13)) . "</td>";

                                            // if ($isi->OK_14 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_14)) . "</td>";

                                            // if ($isi->OK_15 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_15)) . "</td>";

                                            // if ($isi->OK_16 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_16)) . "</td>";


                                            // if ($isi->OK_17 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_17)) . "</td>";


                                            // if ($isi->OK_18 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_18)) . "</td>";


                                            // if ($isi->OK_19 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_19)) . "</td>";


                                            // if ($isi->OK_20 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_20)) . "</td>";


                                            // if ($isi->OK_21 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_21)) . "</td>";


                                            // if ($isi->OK_22 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_22)) . "</td>";


                                            // if ($isi->OK_23 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_23)) . "</td>";


                                            // if ($isi->OK_24 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_24)) . "</td>";


                                            // if ($isi->OK_25 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_25)) . "</td>";


                                            // if ($isi->OK_26 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_26)) . "</td>";


                                            // if ($isi->OK_27 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_27)) . "</td>";


                                            // if ($isi->OK_28 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_28)) . "</td>";


                                            // if ($isi->OK_29 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_29)) . "</td>";


                                            // if ($isi->OK_30 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_30)) . "</td>";


                                            // if ($isi->OK_31 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',', '.', number_format($isi->NG_31)) . "</td>";


                                        ?>
                                            </tr>
                                        <?php
                                        } else {

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL >= 0.1) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL >= 0.5) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.1) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.5) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            echo "<tr>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            $r++;

                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL) . " %</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL_BEFORE) . " %</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.', ',', $isi->CHR_RATIO_AMOUNT_RIL) . " %</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',', '.', number_format($isi->TOTAL)) . "</strong></td>";

                                            echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->TOTAL_PR)) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->TOTAL_BT)) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->TOTAL_TR)) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',', '.', number_format($isi->TOTAL_SU)) . "</td>";


                                            // if ($isi->OK_01 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_01)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_01)) . "</td>";



                                            // if ($isi->OK_02 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_02)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_02)) . "</td>";



                                            // if ($isi->OK_03 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_03)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_03)) . "</td>";


                                            // if ($isi->OK_04 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_04)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_04)) . "</td>";


                                            // if ($isi->OK_05 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_05)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_05)) . "</td>";


                                            // if ($isi->OK_06 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_06)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_06)) . "</td>";


                                            // if ($isi->OK_07 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_07)) . "</td>";
                                            // } 
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_07)) . "</td>";


                                            // if ($isi->OK_08 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_08)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_08)) . "</td>";


                                            // if ($isi->OK_09 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_09)) . "</td>";
                                            // } 
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_09)) . "</td>";


                                            // if ($isi->OK_10 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_10)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_10)) . "</td>";


                                            // if ($isi->OK_11 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_11)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_11)) . "</td>";


                                            // if ($isi->OK_12 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_12)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_12)) . "</td>";


                                            // if ($isi->OK_13 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_13)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_13)) . "</td>";


                                            // if ($isi->OK_14 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_14)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_14)) . "</td>";


                                            // if ($isi->OK_15 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_15)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_15)) . "</td>";


                                            // if ($isi->OK_16 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_16)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_16)) . "</td>";


                                            // if ($isi->OK_17 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_17)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_17)) . "</td>";


                                            // if ($isi->OK_18 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_18)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_18)) . "</td>";


                                            // if ($isi->OK_19 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_19)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_19)) . "</td>";


                                            // if ($isi->OK_20 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_20)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_20)) . "</td>";


                                            // if ($isi->OK_21 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_21)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_21)) . "</td>";


                                            // if ($isi->OK_22 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_22)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_22)) . "</td>";


                                            // if ($isi->OK_23 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_23)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_23)) . "</td>";


                                            // if ($isi->OK_24 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_24)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_24)) . "</td>";


                                            // if ($isi->OK_25 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_25)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_25)) . "</td>";


                                            // if ($isi->OK_26 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_26)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_26)) . "</td>";


                                            // if ($isi->OK_27 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_27)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_27)) . "</td>";


                                            // if ($isi->OK_28 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_28)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_28)) . "</td>";

                                            // if ($isi->OK_29 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_29)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_29)) . "</td>";

                                            // if ($isi->OK_30 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_30)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_30)) . "</td>";


                                            // if ($isi->OK_31 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else {
                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . str_replace(',', '.', number_format($isi->OK_31)) . "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',', '.', number_format($isi->NG_31)) . "</td>";


                                        ?>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>

                                        <th colspan='3' style="text-align:center;">Ratio RIL</th>

                                        <th rowspan="3" style="vertical-align: middle;">Total OK</th>
                                        <th rowspan="3" style="vertical-align: middle;">Total RIL</th>
                                        <th rowspan="3" style="vertical-align: middle;">Grand Total</th>

                                        <th colspan='4' style="text-align:center;">Detail RIL </th>

                                        <th colspan='62' style="text-align:center;">Date </th>
                                    </tr>
                                    <tr class='gradeX'>

                                        <th rowspan="2" style="vertical-align: middle;background:whitesmoke;">Qty YTD</th>
                                        <th rowspan="2" style="vertical-align: middle;background:whitesmoke;">Qty (n-1)</th>
                                        <th rowspan="2" style="vertical-align: middle;background:whitesmoke;">Amount</th>

                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">Process</th>
                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">B.test</th>
                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">Trial</th>
                                        <th rowspan='2' style="vertical-align: middle;background:whitesmoke;">Setup</th>

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
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-right: 1px solid #cdd0d4;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-right: 1px solid #cdd0d4;'>$a</td>";
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
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-right: 1px solid #cdd0d4;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_reject_in_line as $isi) {

                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 10) {

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL >= 0.1) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL >= 0.5) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.1) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.5) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            echo "<tr style=text-align:center; >";
                                            echo "<td style=text-align:center;><strong></strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL) . "</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL_BEFORE) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.', ',', $isi->CHR_RATIO_AMOUNT_RIL) . "</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_OK . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_NG . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL . "</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_PR . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_BT . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_TR . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_SU . "</strong></td>";

                                            if ($isi->OK_01 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_01 . "</td>";
                                            } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_01 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . $isi->OK_01 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_01 . "</td>";

                                            if ($isi->OK_02 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_02 . "</td>";
                                            } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_02 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . $isi->OK_02 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_02 . "</td>";

                                            if ($isi->OK_03 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_03 . "</td>";
                                            } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_03 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . $isi->OK_03 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_03 . "</td>";

                                            if ($isi->OK_04 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_04 . "</td>";
                                            } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_04 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-right: 1px solid #cdd0d4;'>" . $isi->OK_04 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_04 . "</td>";

                                            if ($isi->OK_05 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_05 . "</td>";
                                            } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_05 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_05 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_05 . "</td>";

                                            if ($isi->OK_06 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_06 . "</td>";
                                            } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_06 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_06 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_06 . "</td>";

                                            if ($isi->OK_07 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_07 . "</td>";
                                            } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_07 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_07 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_07 . "</td>";

                                            if ($isi->OK_08 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_08 . "</td>";
                                            } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_08 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_08 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_08 . "</td>";

                                            if ($isi->OK_09 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_09 . "</td>";
                                            } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_09 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_09 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_09 . "</td>";

                                            if ($isi->OK_10 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_10 . "</td>";
                                            } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_10 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_10 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_10 . "</td>";

                                            if ($isi->OK_11 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_11 . "</td>";
                                            } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_11 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_11 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_11 . "</td>";

                                            if ($isi->OK_12 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_12 . "</td>";
                                            } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_12 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_12 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_12 . "</td>";

                                            if ($isi->OK_13 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_13 . "</td>";
                                            } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_13 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_13 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_13 . "</td>";

                                            if ($isi->OK_14 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_14 . "</td>";
                                            } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_14 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_14 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_14 . "</td>";

                                            if ($isi->OK_15 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_15 . "</td>";
                                            } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_15 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_15 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_15 . "</td>";

                                            if ($isi->OK_16 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_16 . "</td>";
                                            } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_16 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_16 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_16 . "</td>";

                                            if ($isi->OK_17 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_17 . "</td>";
                                            } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_17 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_17 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_17 . "</td>";

                                            if ($isi->OK_18 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_18 . "</td>";
                                            } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_18 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_18 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_18 . "</td>";

                                            if ($isi->OK_19 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_19 . "</td>";
                                            } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_19 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_19 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_19 . "</td>";

                                            if ($isi->OK_20 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_20 . "</td>";
                                            } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_20 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_20 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_20 . "</td>";

                                            if ($isi->OK_21 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_21 . "</td>";
                                            } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_21 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_21 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_21 . "</td>";

                                            if ($isi->OK_22 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_22 . "</td>";
                                            } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_22 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_22 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_22 . "</td>";

                                            if ($isi->OK_23 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_23 . "</td>";
                                            } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_23 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_23 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_23 . "</td>";

                                            if ($isi->OK_24 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_24 . "</td>";
                                            } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_24 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_24 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_24 . "</td>";

                                            if ($isi->OK_25 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_25 . "</td>";
                                            } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_25 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_25 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_25 . "</td>";

                                            if ($isi->OK_26 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_26 . "</td>";
                                            } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_26 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_26 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_26 . "</td>";

                                            if ($isi->OK_27 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_27 . "</td>";
                                            } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_27 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_27 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_27 . "</td>";

                                            if ($isi->OK_28 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_28 . "</td>";
                                            } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_28 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_28 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_28 . "</td>";

                                            if ($isi->OK_29 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_29 . "</td>";
                                            } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_29 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_29 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_29 . "</td>";

                                            if ($isi->OK_30 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_30 . "</td>";
                                            } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_30 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_30 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_30 . "</td>";

                                            if ($isi->OK_31 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_31 . "</td>";
                                            } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-right: 1px solid #cdd0d4;color:white;'>" . $isi->OK_31 . "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_31 . "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . $isi->NG_31 . "</td>";


                                    ?>
                                            </tr>
                                        <?php
                                        } else if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL >= 0.1) {
                                                    $color = 'background:#C42820;color:white;';
                                                } else {
                                                    $color = 'background:#0FA819;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL >= 0.5) {
                                                    $color = 'background:#C42820;color:white;';
                                                } else {
                                                    $color = 'background:#0FA819;color:white;';
                                                }
                                            }

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.1) {
                                                    $color_before = 'background:#C42820;color:white;';
                                                } else {
                                                    $color_before = 'background:#0FA819;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.5) {
                                                    $color_before = 'background:#C42820;color:white;';
                                                } else {
                                                    $color_before = 'background:#0FA819;color:white;';
                                                }
                                            }

                                            echo "<tr>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong></strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL) . " %</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL_BEFORE) . " %</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace('.', ',', $isi->CHR_RATIO_AMOUNT_RIL) . " %</strong></td>";

                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->TOTAL_OK . "</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->TOTAL_NG . "</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->TOTAL . "</strong></td>";

                                            echo "<td style=text-align:center;background:#DFDFDF;>" . $isi->TOTAL_PR . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . $isi->TOTAL_BT . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . $isi->TOTAL_TR . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . $isi->TOTAL_SU . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_01 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_01 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_02 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_02 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_03 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_03 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_04 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_04 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_05 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_05 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_06 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_06 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_07 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_07 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_08 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_08 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_09 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_09 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_10 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_10 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_11 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_11 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_12 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_12 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_13 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_13 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_14 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_14 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_15 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_15 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_16 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_16 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_17 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_17 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_18 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_18 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_19 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_19 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_20 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_20 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_21 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_21 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_22 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_22 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_23 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_23 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_24 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_24 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_25 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_25 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_26 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_26 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_27 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_27 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_28 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_28 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_29 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_29 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_30 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_30 . "</td>";

                                            echo "<td style='text-align:center;background:#DFDFDF;border-right: 1px solid #cdd0d4;'>" . $isi->OK_31 . "</td>";
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . $isi->NG_31 . "</td>";


                                        ?>
                                            </tr>
                                        <?php
                                        } else {

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL >= 0.1) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL >= 0.5) {
                                                    $color = 'background:#E34234;color:white;';
                                                } else {
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            if (substr(trim($isi->CHR_WORK_CENTER), 0, 2) == 'AS') {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.1) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            } else {
                                                if ($isi->CHR_RATIO_RIL_BEFORE >= 0.5) {
                                                    $color_before = 'background:#E34234;color:white;';
                                                } else {
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            echo "<tr>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            $r++;

                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL) . " %</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.', ',', $isi->CHR_RATIO_RIL_BEFORE) . " %</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.', ',', $isi->CHR_RATIO_AMOUNT_RIL) . " %</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_OK . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL_NG . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->TOTAL . "</strong></td>";

                                            echo "<td style=text-align:center;>" . $isi->TOTAL_PR . "</td>";
                                            echo "<td style=text-align:center;>" . $isi->TOTAL_BT . "</td>";
                                            echo "<td style=text-align:center;>" . $isi->TOTAL_TR . "</td>";
                                            echo "<td style=text-align:center;>" . $isi->TOTAL_SU . "</td>";


                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_01 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_01 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_02 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_02 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_03 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_03 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_04 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_04 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_05 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_05 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_06 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_06 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_07 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_07 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_08 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_08 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_09 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_09 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_10 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_10 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_11 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_11 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_12 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_12 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_13 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_13 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_14 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_14 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_15 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_15 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_16 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_16 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_17 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_17 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_18 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_18 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_19 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_19 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_20 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_20 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_21 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_21 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_22 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_22 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_23 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_23 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_24 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_24 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_25 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_25 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_26 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_26 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_27 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_27 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_28 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_28 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_29 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_29 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_30 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_30 . "</td>";

                                            echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->OK_31 . "</td>";
                                            echo "<td style='text-align:center;'>" . $isi->NG_31 . "</td>";


                                        ?>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <span style="margin-top:-26px;background:yellow;" class='pull-right'>Data was acquired at <strong><?php echo date('d-m-Y', strtotime($data_date_update->CHR_MODIFIED_DATE)) . ' ' . date('H:i', strtotime($data_date_update->CHR_MODIFIED_TIME)) ?></strong></span>

                        </div>

                        <div class='pull'>
                            <div class='alert alert-info'>
                                <strong>
                                    Formula :</strong>
                                <br>
                                Qty YTD = Ratio RIL dari awal tanggal periode <?php echo $selected_date ?> sampai dengan terakhir produksi periode <?php echo $selected_date ?>
                                <br>
                                Qty (n-1) = Ratio RIL dihari kemarin (jika hari ini senin, data yang diambil hari jumat) pada bulan <?php echo date('F'); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--GRID TO DISPLAY REPORT RIL DETAIL-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REJECT IN LINE DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="vertical-align:top" width="10%">
                                    </td>
                                    <td style="vertical-align:top" width="10%">
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;"><i class="fa fa-download-up"></i></input>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>

                                        <th colspan='4' style="text-align:center;">Total Qty</th>
                                        <th colspan='4' style="text-align:center;">Total Amount</th>

                                        <th colspan='31' style="text-align:center;">Date</th>

                                        <th colspan='8' style="text-align:center;">Date </th>
                                    </tr>
                                    <tr class='gradeX'>

                                        <th rowspan="2" style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Process</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#f45905;color:#FFFFFF;">B.test</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Trial</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Setup</th>

                                        <th rowspan="2" style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Process</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#f45905;color:#FFFFFF;">B.test</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Trial</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Setup</th>


                                        <th colspan='31' style="vertical-align: middle;">Amount total</th>

                                        <th colspan='31' style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Qty Process</th>
                                        <th colspan='31' style="vertical-align: middle;background:#f45905;color:#FFFFFF;">Qty B.test</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Qty Setup</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Qty Trial</th>

                                        <th colspan='31' style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Amount Process</th>
                                        <th colspan='31' style="vertical-align: middle;background:#f45905;color:#FFFFFF;">Amount B.test</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Amount Setup</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Amount Trial</th>

                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($y = 1; $y <= 9; $y++) {
                                            for ($x = 1; $x <= 31; $x++) {
                                                echo "<td style='text-align:center;'><div class='td-fixed'>" . $x . "</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($detail_reject_in_line as $isi) {

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;><strong>$r</strong></td>";
                                        echo "<td style=text-align:center;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                        $total_prc = $isi->PRC_01
                                            + $isi->PRC_02
                                            + $isi->PRC_03
                                            + $isi->PRC_04
                                            + $isi->PRC_05
                                            + $isi->PRC_06
                                            + $isi->PRC_07
                                            + $isi->PRC_08
                                            + $isi->PRC_09
                                            + $isi->PRC_10
                                            + $isi->PRC_11
                                            + $isi->PRC_12
                                            + $isi->PRC_13
                                            + $isi->PRC_14
                                            + $isi->PRC_15
                                            + $isi->PRC_16
                                            + $isi->PRC_17
                                            + $isi->PRC_18
                                            + $isi->PRC_19
                                            + $isi->PRC_20
                                            + $isi->PRC_21
                                            + $isi->PRC_22
                                            + $isi->PRC_23
                                            + $isi->PRC_24
                                            + $isi->PRC_25
                                            + $isi->PRC_26
                                            + $isi->PRC_27
                                            + $isi->PRC_28
                                            + $isi->PRC_29
                                            + $isi->PRC_30
                                            + $isi->PRC_31;

                                        $total_brk = $isi->BRK_01
                                            + $isi->BRK_02
                                            + $isi->BRK_03
                                            + $isi->BRK_04
                                            + $isi->BRK_05
                                            + $isi->BRK_06
                                            + $isi->BRK_07
                                            + $isi->BRK_08
                                            + $isi->BRK_09
                                            + $isi->BRK_10
                                            + $isi->BRK_11
                                            + $isi->BRK_12
                                            + $isi->BRK_13
                                            + $isi->BRK_14
                                            + $isi->BRK_15
                                            + $isi->BRK_16
                                            + $isi->BRK_17
                                            + $isi->BRK_18
                                            + $isi->BRK_19
                                            + $isi->BRK_20
                                            + $isi->BRK_21
                                            + $isi->BRK_22
                                            + $isi->BRK_23
                                            + $isi->BRK_24
                                            + $isi->BRK_25
                                            + $isi->BRK_26
                                            + $isi->BRK_27
                                            + $isi->BRK_28
                                            + $isi->BRK_29
                                            + $isi->BRK_30
                                            + $isi->BRK_31;

                                        $total_stu =  $isi->STU_01
                                            + $isi->STU_02
                                            + $isi->STU_03
                                            + $isi->STU_04
                                            + $isi->STU_05
                                            + $isi->STU_06
                                            + $isi->STU_07
                                            + $isi->STU_08
                                            + $isi->STU_09
                                            + $isi->STU_10
                                            + $isi->STU_11
                                            + $isi->STU_12
                                            + $isi->STU_13
                                            + $isi->STU_14
                                            + $isi->STU_15
                                            + $isi->STU_16
                                            + $isi->STU_17
                                            + $isi->STU_18
                                            + $isi->STU_19
                                            + $isi->STU_20
                                            + $isi->STU_21
                                            + $isi->STU_22
                                            + $isi->STU_23
                                            + $isi->STU_24
                                            + $isi->STU_25
                                            + $isi->STU_26
                                            + $isi->STU_27
                                            + $isi->STU_28
                                            + $isi->STU_29
                                            + $isi->STU_30
                                            + $isi->STU_31;

                                        $total_tri =  $isi->TRI_01
                                            + $isi->TRI_02
                                            + $isi->TRI_03
                                            + $isi->TRI_04
                                            + $isi->TRI_05
                                            + $isi->TRI_06
                                            + $isi->TRI_07
                                            + $isi->TRI_08
                                            + $isi->TRI_09
                                            + $isi->TRI_10
                                            + $isi->TRI_11
                                            + $isi->TRI_12
                                            + $isi->TRI_13
                                            + $isi->TRI_14
                                            + $isi->TRI_15
                                            + $isi->TRI_16
                                            + $isi->TRI_17
                                            + $isi->TRI_18
                                            + $isi->TRI_19
                                            + $isi->TRI_20
                                            + $isi->TRI_21
                                            + $isi->TRI_22
                                            + $isi->TRI_23
                                            + $isi->TRI_24
                                            + $isi->TRI_25
                                            + $isi->TRI_26
                                            + $isi->TRI_27
                                            + $isi->TRI_28
                                            + $isi->TRI_29
                                            + $isi->TRI_30
                                            + $isi->TRI_31;

                                        $total_amount_prc = $isi->APRC_01
                                            + $isi->APRC_02
                                            + $isi->APRC_03
                                            + $isi->APRC_04
                                            + $isi->APRC_05
                                            + $isi->APRC_06
                                            + $isi->APRC_07
                                            + $isi->APRC_08
                                            + $isi->APRC_09
                                            + $isi->APRC_10
                                            + $isi->APRC_11
                                            + $isi->APRC_12
                                            + $isi->APRC_13
                                            + $isi->APRC_14
                                            + $isi->APRC_15
                                            + $isi->APRC_16
                                            + $isi->APRC_17
                                            + $isi->APRC_18
                                            + $isi->APRC_19
                                            + $isi->APRC_20
                                            + $isi->APRC_21
                                            + $isi->APRC_22
                                            + $isi->APRC_23
                                            + $isi->APRC_24
                                            + $isi->APRC_25
                                            + $isi->APRC_26
                                            + $isi->APRC_27
                                            + $isi->APRC_28
                                            + $isi->APRC_29
                                            + $isi->APRC_30
                                            + $isi->APRC_31;

                                        $total_amount_brk = $isi->ABRK_01
                                            + $isi->ABRK_02
                                            + $isi->ABRK_03
                                            + $isi->ABRK_04
                                            + $isi->ABRK_05
                                            + $isi->ABRK_06
                                            + $isi->ABRK_07
                                            + $isi->ABRK_08
                                            + $isi->ABRK_09
                                            + $isi->ABRK_10
                                            + $isi->ABRK_11
                                            + $isi->ABRK_12
                                            + $isi->ABRK_13
                                            + $isi->ABRK_14
                                            + $isi->ABRK_15
                                            + $isi->ABRK_16
                                            + $isi->ABRK_17
                                            + $isi->ABRK_18
                                            + $isi->ABRK_19
                                            + $isi->ABRK_20
                                            + $isi->ABRK_21
                                            + $isi->ABRK_22
                                            + $isi->ABRK_23
                                            + $isi->ABRK_24
                                            + $isi->ABRK_25
                                            + $isi->ABRK_26
                                            + $isi->ABRK_27
                                            + $isi->ABRK_28
                                            + $isi->ABRK_29
                                            + $isi->ABRK_30
                                            + $isi->ABRK_31;

                                        $total_amount_stu =  $isi->ASTU_01
                                            + $isi->ASTU_02
                                            + $isi->ASTU_03
                                            + $isi->ASTU_04
                                            + $isi->ASTU_05
                                            + $isi->ASTU_06
                                            + $isi->ASTU_07
                                            + $isi->ASTU_08
                                            + $isi->ASTU_09
                                            + $isi->ASTU_10
                                            + $isi->ASTU_11
                                            + $isi->ASTU_12
                                            + $isi->ASTU_13
                                            + $isi->ASTU_14
                                            + $isi->ASTU_15
                                            + $isi->ASTU_16
                                            + $isi->ASTU_17
                                            + $isi->ASTU_18
                                            + $isi->ASTU_19
                                            + $isi->ASTU_20
                                            + $isi->ASTU_21
                                            + $isi->ASTU_22
                                            + $isi->ASTU_23
                                            + $isi->ASTU_24
                                            + $isi->ASTU_25
                                            + $isi->ASTU_26
                                            + $isi->ASTU_27
                                            + $isi->ASTU_28
                                            + $isi->ASTU_29
                                            + $isi->ASTU_30
                                            + $isi->ASTU_31;

                                        $total_amount_tri =  $isi->ATRI_01
                                            + $isi->ATRI_02
                                            + $isi->ATRI_03
                                            + $isi->ATRI_04
                                            + $isi->ATRI_05
                                            + $isi->ATRI_06
                                            + $isi->ATRI_07
                                            + $isi->ATRI_08
                                            + $isi->ATRI_09
                                            + $isi->ATRI_10
                                            + $isi->ATRI_11
                                            + $isi->ATRI_12
                                            + $isi->ATRI_13
                                            + $isi->ATRI_14
                                            + $isi->ATRI_15
                                            + $isi->ATRI_16
                                            + $isi->ATRI_17
                                            + $isi->ATRI_18
                                            + $isi->ATRI_19
                                            + $isi->ATRI_20
                                            + $isi->ATRI_21
                                            + $isi->ATRI_22
                                            + $isi->ATRI_23
                                            + $isi->ATRI_24
                                            + $isi->ATRI_25
                                            + $isi->ATRI_26
                                            + $isi->ATRI_27
                                            + $isi->ATRI_28
                                            + $isi->ATRI_29
                                            + $isi->ATRI_30
                                            + $isi->ATRI_31;

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_prc) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_brk) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_stu) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_tri) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_prc) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_brk) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_stu) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($total_amount_tri) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->AMOUNTNG_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->PRC_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->BRK_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->STU_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->TRI_31) . "</td>";


                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->APRC_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ABRK_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ASTU_31) . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_01) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_02) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_03) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_04) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_05) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_06) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_07) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_08) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_09) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_10) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_11) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_12) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_13) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_14) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_15) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_16) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_17) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_18) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_19) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_20) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_21) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_22) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_23) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_24) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_25) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_26) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_27) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_28) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_29) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_30) . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . number_format($isi->ATRI_31) . "</td>";


                                        $r++;
                                    ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>

                                        <th colspan='4' style="text-align:center;">Total Qty</th>
                                        <th colspan='4' style="text-align:center;">Total Amount</th>

                                        <th colspan='31' style="text-align:center;">Date</th>

                                        <th colspan='8' style="text-align:center;">Date </th>
                                    </tr>
                                    <tr class='gradeX'>

                                        <th rowspan="2" style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Process</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#f45905;color:#FFFFFF;">B.test</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Setup</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Trial</th>

                                        <th rowspan="2" style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Process</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#f45905;color:#FFFFFF;">B.test</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Setup</th>
                                        <th rowspan="2" style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Trial</th>

                                        <th colspan='31' style="vertical-align: middle;">Amount total</th>

                                        <th colspan='31' style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Qty Process</th>
                                        <th colspan='31' style="vertical-align: middle;background:#f45905;color:#FFFFFF;">Qty B.test</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Qty Setup</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Qty Trial</th>

                                        <th colspan='31' style="vertical-align: middle;background:#2a1a5e;color:#FFFFFF;">Amount Process</th>
                                        <th colspan='31' style="vertical-align: middle;background:#f45905;color:#FFFFFF;">Amount B.test</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fbe555;color:#FFFFFF;">Amount Setup</th>
                                        <th colspan='31' style="vertical-align: middle;background:#fb9224;color:#FFFFFF;">Amount Trial</th>

                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($y = 1; $y <= 9; $y++) {
                                            for ($x = 1; $x <= 31; $x++) {
                                                echo "<td style='text-align:center;'><div class='td-fixed'>" . $x . "</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($detail_reject_in_line as $isi) {

                                        echo "<tr style=text-align:center; >";
                                        echo "<td style=text-align:center;><strong>$r</strong></td>";
                                        echo "<td style=text-align:center;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                        $total_prc = $isi->PRC_01
                                            + $isi->PRC_02
                                            + $isi->PRC_03
                                            + $isi->PRC_04
                                            + $isi->PRC_05
                                            + $isi->PRC_06
                                            + $isi->PRC_07
                                            + $isi->PRC_08
                                            + $isi->PRC_09
                                            + $isi->PRC_10
                                            + $isi->PRC_11
                                            + $isi->PRC_12
                                            + $isi->PRC_13
                                            + $isi->PRC_14
                                            + $isi->PRC_15
                                            + $isi->PRC_16
                                            + $isi->PRC_17
                                            + $isi->PRC_18
                                            + $isi->PRC_19
                                            + $isi->PRC_20
                                            + $isi->PRC_21
                                            + $isi->PRC_22
                                            + $isi->PRC_23
                                            + $isi->PRC_24
                                            + $isi->PRC_25
                                            + $isi->PRC_26
                                            + $isi->PRC_27
                                            + $isi->PRC_28
                                            + $isi->PRC_29
                                            + $isi->PRC_30
                                            + $isi->PRC_31;

                                        $total_brk = $isi->BRK_01
                                            + $isi->BRK_02
                                            + $isi->BRK_03
                                            + $isi->BRK_04
                                            + $isi->BRK_05
                                            + $isi->BRK_06
                                            + $isi->BRK_07
                                            + $isi->BRK_08
                                            + $isi->BRK_09
                                            + $isi->BRK_10
                                            + $isi->BRK_11
                                            + $isi->BRK_12
                                            + $isi->BRK_13
                                            + $isi->BRK_14
                                            + $isi->BRK_15
                                            + $isi->BRK_16
                                            + $isi->BRK_17
                                            + $isi->BRK_18
                                            + $isi->BRK_19
                                            + $isi->BRK_20
                                            + $isi->BRK_21
                                            + $isi->BRK_22
                                            + $isi->BRK_23
                                            + $isi->BRK_24
                                            + $isi->BRK_25
                                            + $isi->BRK_26
                                            + $isi->BRK_27
                                            + $isi->BRK_28
                                            + $isi->BRK_29
                                            + $isi->BRK_30
                                            + $isi->BRK_31;

                                        $total_stu =  $isi->STU_01
                                            + $isi->STU_02
                                            + $isi->STU_03
                                            + $isi->STU_04
                                            + $isi->STU_05
                                            + $isi->STU_06
                                            + $isi->STU_07
                                            + $isi->STU_08
                                            + $isi->STU_09
                                            + $isi->STU_10
                                            + $isi->STU_11
                                            + $isi->STU_12
                                            + $isi->STU_13
                                            + $isi->STU_14
                                            + $isi->STU_15
                                            + $isi->STU_16
                                            + $isi->STU_17
                                            + $isi->STU_18
                                            + $isi->STU_19
                                            + $isi->STU_20
                                            + $isi->STU_21
                                            + $isi->STU_22
                                            + $isi->STU_23
                                            + $isi->STU_24
                                            + $isi->STU_25
                                            + $isi->STU_26
                                            + $isi->STU_27
                                            + $isi->STU_28
                                            + $isi->STU_29
                                            + $isi->STU_30
                                            + $isi->STU_31;

                                        $total_tri =  $isi->TRI_01
                                            + $isi->TRI_02
                                            + $isi->TRI_03
                                            + $isi->TRI_04
                                            + $isi->TRI_05
                                            + $isi->TRI_06
                                            + $isi->TRI_07
                                            + $isi->TRI_08
                                            + $isi->TRI_09
                                            + $isi->TRI_10
                                            + $isi->TRI_11
                                            + $isi->TRI_12
                                            + $isi->TRI_13
                                            + $isi->TRI_14
                                            + $isi->TRI_15
                                            + $isi->TRI_16
                                            + $isi->TRI_17
                                            + $isi->TRI_18
                                            + $isi->TRI_19
                                            + $isi->TRI_20
                                            + $isi->TRI_21
                                            + $isi->TRI_22
                                            + $isi->TRI_23
                                            + $isi->TRI_24
                                            + $isi->TRI_25
                                            + $isi->TRI_26
                                            + $isi->TRI_27
                                            + $isi->TRI_28
                                            + $isi->TRI_29
                                            + $isi->TRI_30
                                            + $isi->TRI_31;

                                        $total_amount_prc = $isi->APRC_01
                                            + $isi->APRC_02
                                            + $isi->APRC_03
                                            + $isi->APRC_04
                                            + $isi->APRC_05
                                            + $isi->APRC_06
                                            + $isi->APRC_07
                                            + $isi->APRC_08
                                            + $isi->APRC_09
                                            + $isi->APRC_10
                                            + $isi->APRC_11
                                            + $isi->APRC_12
                                            + $isi->APRC_13
                                            + $isi->APRC_14
                                            + $isi->APRC_15
                                            + $isi->APRC_16
                                            + $isi->APRC_17
                                            + $isi->APRC_18
                                            + $isi->APRC_19
                                            + $isi->APRC_20
                                            + $isi->APRC_21
                                            + $isi->APRC_22
                                            + $isi->APRC_23
                                            + $isi->APRC_24
                                            + $isi->APRC_25
                                            + $isi->APRC_26
                                            + $isi->APRC_27
                                            + $isi->APRC_28
                                            + $isi->APRC_29
                                            + $isi->APRC_30
                                            + $isi->APRC_31;

                                        $total_amount_brk = $isi->ABRK_01
                                            + $isi->ABRK_02
                                            + $isi->ABRK_03
                                            + $isi->ABRK_04
                                            + $isi->ABRK_05
                                            + $isi->ABRK_06
                                            + $isi->ABRK_07
                                            + $isi->ABRK_08
                                            + $isi->ABRK_09
                                            + $isi->ABRK_10
                                            + $isi->ABRK_11
                                            + $isi->ABRK_12
                                            + $isi->ABRK_13
                                            + $isi->ABRK_14
                                            + $isi->ABRK_15
                                            + $isi->ABRK_16
                                            + $isi->ABRK_17
                                            + $isi->ABRK_18
                                            + $isi->ABRK_19
                                            + $isi->ABRK_20
                                            + $isi->ABRK_21
                                            + $isi->ABRK_22
                                            + $isi->ABRK_23
                                            + $isi->ABRK_24
                                            + $isi->ABRK_25
                                            + $isi->ABRK_26
                                            + $isi->ABRK_27
                                            + $isi->ABRK_28
                                            + $isi->ABRK_29
                                            + $isi->ABRK_30
                                            + $isi->ABRK_31;

                                        $total_amount_stu =  $isi->ASTU_01
                                            + $isi->ASTU_02
                                            + $isi->ASTU_03
                                            + $isi->ASTU_04
                                            + $isi->ASTU_05
                                            + $isi->ASTU_06
                                            + $isi->ASTU_07
                                            + $isi->ASTU_08
                                            + $isi->ASTU_09
                                            + $isi->ASTU_10
                                            + $isi->ASTU_11
                                            + $isi->ASTU_12
                                            + $isi->ASTU_13
                                            + $isi->ASTU_14
                                            + $isi->ASTU_15
                                            + $isi->ASTU_16
                                            + $isi->ASTU_17
                                            + $isi->ASTU_18
                                            + $isi->ASTU_19
                                            + $isi->ASTU_20
                                            + $isi->ASTU_21
                                            + $isi->ASTU_22
                                            + $isi->ASTU_23
                                            + $isi->ASTU_24
                                            + $isi->ASTU_25
                                            + $isi->ASTU_26
                                            + $isi->ASTU_27
                                            + $isi->ASTU_28
                                            + $isi->ASTU_29
                                            + $isi->ASTU_30
                                            + $isi->ASTU_31;

                                        $total_amount_tri =  $isi->ATRI_01
                                            + $isi->ATRI_02
                                            + $isi->ATRI_03
                                            + $isi->ATRI_04
                                            + $isi->ATRI_05
                                            + $isi->ATRI_06
                                            + $isi->ATRI_07
                                            + $isi->ATRI_08
                                            + $isi->ATRI_09
                                            + $isi->ATRI_10
                                            + $isi->ATRI_11
                                            + $isi->ATRI_12
                                            + $isi->ATRI_13
                                            + $isi->ATRI_14
                                            + $isi->ATRI_15
                                            + $isi->ATRI_16
                                            + $isi->ATRI_17
                                            + $isi->ATRI_18
                                            + $isi->ATRI_19
                                            + $isi->ATRI_20
                                            + $isi->ATRI_21
                                            + $isi->ATRI_22
                                            + $isi->ATRI_23
                                            + $isi->ATRI_24
                                            + $isi->ATRI_25
                                            + $isi->ATRI_26
                                            + $isi->ATRI_27
                                            + $isi->ATRI_28
                                            + $isi->ATRI_29
                                            + $isi->ATRI_30
                                            + $isi->ATRI_31;

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_prc . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_brk . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_stu . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_tri . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_amount_prc . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_amount_brk . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_amount_stu . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $total_amount_tri . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->AMOUNTNG_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->PRC_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->BRK_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->STU_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->TRI_31 . "</td>";


                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->APRC_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ABRK_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ASTU_31 . "</td>";

                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_01 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_02 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_03 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_04 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_05 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_06 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_07 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_08 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_09 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_10 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_11 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_12 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_13 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_14 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_15 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_16 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_17 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_18 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_19 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_20 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_21 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_22 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_23 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_24 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_25 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_26 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_27 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_28 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_29 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_30 . "</td>";
                                        echo "<td style='text-align:center;border-right: 1px solid #cdd0d4;'>" . $isi->ATRI_31 . "</td>";


                                        $r++;
                                    ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <span style="margin-top:-26px;background:yellow;" class='pull-right'>Data was acquired at <strong><?php echo date('d-m-Y', strtotime($detail_date_update->CHR_MODIFIED_DATE)) . ' ' . date('H:i', strtotime($detail_date_update->CHR_MODIFIED_TIME)) ?></strong></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY REPORT RIL DETAIL-->

        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REJECT IN LINE CHART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe src="<?php echo site_url('pes_new/report_reject_in_line_c/get_chart_ril/' . $selected_date); ?>" height="400px" width="100%" style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->

        <!--DATA DETAIL RIL-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REJECT IN LINE (QTY)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe src="<?php echo site_url('pes_new/report_reject_in_line_c/chart_fiscal_ril/' . $selected_date); ?>" height="370px" width="100%" style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--GDATA DETAIL RIL-->

        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">

                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>REJECT IN LINE (AMOUNT)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe src="<?php echo site_url('pes_new/report_reject_in_line_c/chart_fiscal_ril_amount/' . $selected_date); ?>" height="370px" width="100%" style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--GRID TO DISPLAY DIAGRAM EFFICIENCY CHART-->

    </section>
</aside>
<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {

        var table = $('#example').DataTable({
            scrollY: "600px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: {
                leftColumns: 4
            }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();

        var table = $('#example2').DataTable({
            scrollY: "600px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs: [{
                sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: {
                leftColumns: 2
            }
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                //cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>