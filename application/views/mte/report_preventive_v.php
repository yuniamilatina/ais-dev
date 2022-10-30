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
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 25);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PREVENTIVE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PREVENTIVE</strong></span>
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
                                                <option value="<?php echo site_url('mte/report_preventive_c/report_preventive/' . date("Ym", strtotime("+$y day")) . '/' . $group_line); ?>" <?php
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
                                                <option value="<?php echo site_url('mte/report_preventive_c/report_preventive/' . $selected_date . '/' . $row->ID); ?>" <?php
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
                                    <?php echo form_close(); ?>
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle; text-align:center;">No</th>
                                        <th rowspan="3" style="vertical-align: middle; text-align:center;">Item</th>
                                        <th rowspan="3" style="vertical-align: middle; text-align:center;">Std Stroke Preventive</th>

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
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                    <tr class='gradeX'>
                                    <?php
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;'><div class='td-fixed'>TYPE</div></td>";
                                            echo "<td style='text-align:center;border-right-width: 0;'><div class='td-fixed'>PLAN</div></td>";
                                            echo "<td style='text-align:center;border-right-width: 0;'><div class='td-fixed'>ACT</div></td>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody
                                    <?php
                                    $r = 1;
                                    foreach ($get_data_preventive_mte_report_daily as $isi) {
                                            echo "<tr style=text-align:center;>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_PART_CODE</td>";
                                            echo "<td style=text-align:center;>$isi->INT_STROKE_SMALL_PREVENTIVE</td>";
                                            if ($isi->TYPE_01 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_01 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_01 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_01 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_01 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_01)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_01)). "</td>";

                                            if ($isi->TYPE_02 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_02 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_02 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_02 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_02 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_02)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_02)). "</td>";
                                            
                                            if ($isi->TYPE_03 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_03 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_03 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_03 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_03 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_03)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_03)). "</td>";
                                            
                                            if ($isi->TYPE_04 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_04 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_04 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_04 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_04 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_04)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_04)). "</td>";
                                            
                                            if ($isi->TYPE_05 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_05 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_05 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_05 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_05 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_05)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_05)). "</td>";
                                            
                                            if ($isi->TYPE_06 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_06 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_06 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_06 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_06 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_06)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_06)). "</td>";
                                            
                                            if ($isi->TYPE_07 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_07 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_07 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_07 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_07 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_07)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_07)). "</td>";
                                            
                                            if ($isi->TYPE_08 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_08 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_08 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_08 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_08 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_08)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_08)). "</td>";
                                            
                                            if ($isi->TYPE_09 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_09 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_09 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_09 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_09 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_09)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_09)). "</td>";
                                            
                                            if ($isi->TYPE_10 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_10 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_10 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_10 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_10 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_10)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_10)). "</td>";
                                            
                                            if ($isi->TYPE_11 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_11 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_11 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_11 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_11 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_11)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_11)). "</td>";
                                            
                                            if ($isi->TYPE_12 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_12 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_12 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_12 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_12 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_12)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_12)). "</td>";
                                            
                                            if ($isi->TYPE_13 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_13 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_13 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_13 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_13 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_13)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_13)). "</td>";
                                            
                                            if ($isi->TYPE_14 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_14 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_14 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_14 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_14 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_14)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_14)). "</td>";
                                            
                                            if ($isi->TYPE_15 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_15 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_15 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_15 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_15 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_15)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_15)). "</td>";
                                            
                                            if ($isi->TYPE_16 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_16 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_16 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_16 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_16 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_16)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_16)). "</td>";
                                            
                                            if ($isi->TYPE_17 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_17 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_17 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_17 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_17 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_17)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_17)). "</td>";
                                            
                                            if ($isi->TYPE_18 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_18 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_18 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_18 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_18 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_18)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_18)). "</td>";
                                            
                                            if ($isi->TYPE_19 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_19 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_19 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_19 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_19 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_19)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_19)). "</td>";
                                            
                                            if ($isi->TYPE_20 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_20 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_15 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_15 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_15 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_20)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_20)). "</td>";
                                            
                                            if ($isi->TYPE_21 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_21 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_21 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_21 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_21 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_21)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_21)). "</td>";
                                            
                                            if ($isi->TYPE_22 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_22 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_22 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_22 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_22 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_22)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_22)). "</td>";
                                            
                                            if ($isi->TYPE_23 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_23 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_23 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_23 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_23 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_23)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_23)). "</td>";
                                            
                                            if ($isi->TYPE_24 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_24 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_24 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_24 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_24 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_24)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_24)). "</td>";
                                            
                                            if ($isi->TYPE_25 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_25 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_25 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_25 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_25 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_25)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_25)). "</td>";
                                            
                                            if ($isi->TYPE_26 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_26 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_26 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_26 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_26 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_26)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_26)). "</td>";
                                            
                                            if ($isi->TYPE_27 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_27 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_27 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_27 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_27 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_27)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_27)). "</td>";
                                            
                                            if ($isi->TYPE_28 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_28 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_28 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_28 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_28 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_28)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_28)). "</td>";
                                            
                                            if ($isi->TYPE_29 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_29 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_29 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_29 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_29 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_29)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_29)). "</td>";
                                            
                                            if ($isi->TYPE_30 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_30 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_30 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_30 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_30 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_30)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_30)). "</td>";

                                            if ($isi->TYPE_31 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_31 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_31 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_31 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_31 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_31)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_31)). "</td>";
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
                                        <th rowspan="3" style="vertical-align: middle; text-align:center;">No</th>
                                        <th rowspan="3" style="vertical-align: middle; text-align:center;">Item</th>

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
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:#E83941;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='3' style='text-align:center;background:#61C6F1;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='3' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                    </tr>
                                    <tr class='gradeX'>
                                    <?php
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td style='text-align:center;border-left-width: 0.1em;'><div class='td-fixed'>TYPE</div></td>";
                                            echo "<td style='text-align:center;border-right-width: 0;'><div class='td-fixed'>PLAN</div></td>";
                                            echo "<td style='text-align:center;border-right-width: 0;'><div class='td-fixed'>ACT</div></td>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody
                                    <?php
                                    $r = 1;
                                    foreach ($get_data_preventive_mte_report_daily as $isi) {
                                            echo "<tr style=text-align:center;>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            echo "<td style=text-align:center;>$isi->CHR_PART_CODE</td>";

                                            if ($isi->TYPE_01 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_01 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_01 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_01 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_01 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_01)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_01)). "</td>";

                                            if ($isi->TYPE_02 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_02 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_02 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_02 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_02 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_02)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_02)). "</td>";
                                            
                                            if ($isi->TYPE_03 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_03 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_03 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_03 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_03 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_03)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_03)). "</td>";
                                            
                                            if ($isi->TYPE_04 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_04 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_04 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_04 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_04 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_04)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_04)). "</td>";
                                            
                                            if ($isi->TYPE_05 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_05 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_05 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_05 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_05 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_05)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_05)). "</td>";
                                            
                                            if ($isi->TYPE_06 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_06 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_06 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_06 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_06 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_06)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_06)). "</td>";
                                            
                                            if ($isi->TYPE_07 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_07 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_07 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_07 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_07 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_07)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_07)). "</td>";
                                            
                                            if ($isi->TYPE_08 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_08 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_08 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_08 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_08 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_08)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_08)). "</td>";
                                            
                                            if ($isi->TYPE_09 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_09 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_09 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_09 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_09 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_09)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_09)). "</td>";
                                            
                                            if ($isi->TYPE_10 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_10 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_10 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_10 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_10 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_10)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_10)). "</td>";
                                            
                                            if ($isi->TYPE_11 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_11 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_11 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_11 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_11 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_11)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_11)). "</td>";
                                            
                                            if ($isi->TYPE_12 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_12 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_12 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_12 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_12 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_12)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_12)). "</td>";
                                            
                                            if ($isi->TYPE_13 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_13 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_13 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_13 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_13 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_13)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_13)). "</td>";
                                            
                                            if ($isi->TYPE_14 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_14 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_14 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_14 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_14 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_14)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_14)). "</td>";
                                            
                                            if ($isi->TYPE_15 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_15 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_15 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_15 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_15 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_15)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_15)). "</td>";
                                            
                                            if ($isi->TYPE_16 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_16 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_16 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_16 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_16 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_16)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_16)). "</td>";
                                            
                                            if ($isi->TYPE_17 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_17 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_17 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_17 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_17 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_17)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_17)). "</td>";
                                            
                                            if ($isi->TYPE_18 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_18 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_18 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_18 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_18 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_18)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_18)). "</td>";
                                            
                                            if ($isi->TYPE_19 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_19 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_19 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_19 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_19 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_19)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_19)). "</td>";
                                            
                                            if ($isi->TYPE_20 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_20 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_15 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_15 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_15 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_20)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_20)). "</td>";
                                            
                                            if ($isi->TYPE_21 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_21 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_21 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_21 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_21 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_21)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_21)). "</td>";
                                            
                                            if ($isi->TYPE_22 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_22 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_22 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_22 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_22 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_22)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_22)). "</td>";
                                            
                                            if ($isi->TYPE_23 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_23 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_23 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_23 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_23 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_23)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_23)). "</td>";
                                            
                                            if ($isi->TYPE_24 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_24 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_24 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_24 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_24 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_24)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_24)). "</td>";
                                            
                                            if ($isi->TYPE_25 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_25 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_25 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_25 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_25 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_25)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_25)). "</td>";
                                            
                                            if ($isi->TYPE_26 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_26 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_26 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_26 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_26 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_26)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_26)). "</td>";
                                            
                                            if ($isi->TYPE_27 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_27 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_27 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_27 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_27 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_27)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_27)). "</td>";
                                            
                                            if ($isi->TYPE_28 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_28 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_28 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_28 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_28 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_28)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_28)). "</td>";
                                            
                                            if ($isi->TYPE_29 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_29 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_29 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_29 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_29 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_29)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_29)). "</td>";
                                            
                                            if ($isi->TYPE_30 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_30 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_30 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_30 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_30 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_30)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_30)). "</td>";

                                            if ($isi->TYPE_31 == '1') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#2E86C1; color: white;'>SMALL</td>";
                                            } elseif ($isi->TYPE_31 == '2') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:#FF5733; color: white;'>BIG</td>";
                                            } elseif ($isi->TYPE_31 == '3') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:pink;'>3M</td>";
                                            } elseif ($isi->TYPE_31 == '4') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:yellow;'>6M</td>";
                                            } elseif ($isi->TYPE_31 == '5') {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0; background:green; color: white;'>12M</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>-</td>";
                                            }
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->PLAN_31)). "</td>";
                                            echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->ACT_31)). "</td>";
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