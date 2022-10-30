<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 0px 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 140px;
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
            <li><a href=""><strong>REPORT OPERATIONAL AVAILABILITY</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT OPERATIONAL AVAILABILITY (%)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'  style="margin-bottom:-20px;">
                                <tr>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -31; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('pes_new/report_efficiency_c/index/' . date("Ym", strtotime("+$x month")) . '/' . $id_product_group  ); ?>"<?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                            <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php foreach ($all_product_group as $row) { ?>
                                                    <option value="<?php echo site_url('pes_new/report_efficiency_c/index/' . $selected_date . '/' . $row->INT_ID); ?>" <?php
                                                    if ($id_product_group == $row->INT_ID) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_PRODUCT_GROUP); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="70%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Prod. OA')" value="Export to Excel" style="margin-bottom: 20px;">
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
                                        <th rowspan="2" style="vertical-align: middle;"><strong>Work Time (m)</strong></th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>loss Time (m)</strong></th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>Total Qty</strong></th>
                                        
                                        <th colspan='31' style="text-align:center;">Date (%)</th>
                                       
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
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
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
                                    foreach ($data_effiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;><strong>$isi->CHR_WORK_CENTER</strong></td>";

                                        echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->TOTAL_WORK_TIME /60 )) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->TOTAL_STOP_TIME /60 )) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->TOTAL_QTY)) . "</td>";

                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_01) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_02) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_03) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_04) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_05) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_06) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_07) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_08) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_09) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_10) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_11) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_12) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_13) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_14) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_15) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_16) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_17) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_18) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_19) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_20) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_21) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_22) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_23) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_24) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_25) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_26) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_27) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_28) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_29) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_30) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_31) . "</td>";
                                       
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>Work Center</strong></th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>Work Time (m)</strong></th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>loss Time (m)</strong></th>
                                        <th rowspan="2" style="vertical-align: middle;"><strong>Total Qty</strong></th>
                                        
                                        <th colspan='31' style="text-align:center;">Date (%)</th>
                                       
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
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='1' style='text-align:center;background:whitesmoke;'>$a</td>";
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
                                    foreach ($data_effiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;><strong>$isi->CHR_WORK_CENTER</strong></td>";

                                        echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->TOTAL_WORK_TIME /60 )) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->TOTAL_STOP_TIME /60 )) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->TOTAL_QTY)) . "</td>";

                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_01) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_02) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_03) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_04) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_05) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_06) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_07) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_08) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_09) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_10) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_11) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_12) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_13) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_14) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_15) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_16) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_17) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_18) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_19) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_20) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_21) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_22) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_23) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_24) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_25) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_26) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_27) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_28) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_29) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_30) . "</td>";
                                        echo "<td style='text-align:center;'>" . str_replace('.',',',$isi->DATE_31) . "</td>";
                                       
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
                                <strong>Formula : </strong> Total OK * CT / (Work Time - Loss time) * 100
                            </div >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT DOWNTIME</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;" border=0px>
                                <tr>
                                    <td style="vertical-align:top" width="80%">
                                        
                                        <table width="75%" style="border-collapse: collapse;  border-radius: 0.1em;border-spacing: 5px; background:#8EED93;color:#067328;font-size:9pt;" border=0px>
                                        <tr>
                                            <td style="padding-left: 1em;padding-top: 1em;" width="25%"><strong>001</strong> : Mesin & Jig Problem</td>
                                            <td style="padding-left: 1em;padding-top: 1em;" width="25%"><strong>002</strong> : Quality Problem</td>
                                            <td style="padding-left: 1em;padding-top: 1em;" width="25%"><strong>003</strong> : Tunggu Material</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 1em;padding-bottom: 1em;" ><strong>004</strong> : Dandory</td>
                                            <td style="padding-left: 1em;padding-bottom: 1em;" ><strong>005</strong> : QA Check</td>
                                            <td style="padding-left: 1em;padding-bottom: 1em;" ><strong>006</strong> : Others</td>
                                        </tr>
                                        </table>

                                    </td>
                                    
                                    <td width="20%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Report Reject In Line')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Work Center</strong></th>
                                        <th colspan="217" style="text-align:center;">Date (Min)</th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 001 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 002 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 003 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 004 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 005 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 006 (m) </strong></th>
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
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>

                                    <?php 
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td style='text-align:center;background:whitesmoke;'>001</td>";
                                            echo "<td style='text-align:center;background:whitesmoke;'>002</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>003</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>004</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>005</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>006</td>";
                                            echo "<td style='text-align:center;background:#5FFA6F;'>Total</td>"; 
                                        }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_downtime as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;><strong>$isi->CHR_WORK_CENTER</strong></td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_01 + $isi->L002_01 + $isi->L003_01 + $isi->L004_01 + $isi->L005_01 + $isi->L006_01)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_02 + $isi->L002_02 + $isi->L003_02 + $isi->L004_02 + $isi->L005_02 + $isi->L006_02)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_03 + $isi->L002_03 + $isi->L003_03 + $isi->L004_03 + $isi->L005_03 + $isi->L006_03)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_04 + $isi->L002_04 + $isi->L003_04 + $isi->L004_04 + $isi->L005_04 + $isi->L006_04)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_05 + $isi->L002_05 + $isi->L003_05 + $isi->L004_05 + $isi->L005_05 + $isi->L006_05)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_06 + $isi->L002_06 + $isi->L003_06 + $isi->L004_06 + $isi->L005_06 + $isi->L006_06)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_07 + $isi->L002_07 + $isi->L003_07 + $isi->L004_07 + $isi->L005_07 + $isi->L006_07)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_08 + $isi->L002_08 + $isi->L003_08 + $isi->L004_08 + $isi->L005_08 + $isi->L006_08)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_09 + $isi->L002_09 + $isi->L003_09 + $isi->L004_09 + $isi->L005_09 + $isi->L006_09)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_10 + $isi->L002_10 + $isi->L003_10 + $isi->L004_10 + $isi->L005_10 + $isi->L006_10)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_11 + $isi->L002_11 + $isi->L003_11 + $isi->L004_11 + $isi->L005_11 + $isi->L006_11)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_12 + $isi->L002_12 + $isi->L003_12 + $isi->L004_12 + $isi->L005_12 + $isi->L006_12)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_13 + $isi->L002_13 + $isi->L003_13 + $isi->L004_13 + $isi->L005_13 + $isi->L006_13)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_14 + $isi->L002_14 + $isi->L003_14 + $isi->L004_14 + $isi->L005_14 + $isi->L006_14)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_15 + $isi->L002_15 + $isi->L003_15 + $isi->L004_15 + $isi->L005_15 + $isi->L006_15)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_16 + $isi->L002_16 + $isi->L003_16 + $isi->L004_16 + $isi->L005_16 + $isi->L006_16)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_17 + $isi->L002_17 + $isi->L003_17 + $isi->L004_17 + $isi->L005_17 + $isi->L006_17)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_18 + $isi->L002_18 + $isi->L003_18 + $isi->L004_18 + $isi->L005_18 + $isi->L006_18)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_19 + $isi->L002_19 + $isi->L003_19 + $isi->L004_19 + $isi->L005_19 + $isi->L006_19)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_20 + $isi->L002_20 + $isi->L003_20 + $isi->L004_20 + $isi->L005_20 + $isi->L006_20)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_21 + $isi->L002_21 + $isi->L003_21 + $isi->L004_21 + $isi->L005_21 + $isi->L006_21)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_22 + $isi->L002_22 + $isi->L003_22 + $isi->L004_22 + $isi->L005_22 + $isi->L006_22)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_23 + $isi->L002_23 + $isi->L003_23 + $isi->L004_23 + $isi->L005_23 + $isi->L006_23)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_24 + $isi->L002_24 + $isi->L003_24 + $isi->L004_24 + $isi->L005_24 + $isi->L006_24)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_25 + $isi->L002_25 + $isi->L003_25 + $isi->L004_25 + $isi->L005_25 + $isi->L006_25)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_26 + $isi->L002_26 + $isi->L003_26 + $isi->L004_26 + $isi->L005_26 + $isi->L006_26)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_27 + $isi->L002_27 + $isi->L003_27 + $isi->L004_27 + $isi->L005_27 + $isi->L006_27)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_28 + $isi->L002_28 + $isi->L003_28 + $isi->L004_28 + $isi->L005_28 + $isi->L006_28)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_29 + $isi->L002_29 + $isi->L003_29 + $isi->L004_29 + $isi->L005_29 + $isi->L006_29)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_30 + $isi->L002_30 + $isi->L003_30 + $isi->L004_30 + $isi->L005_30 + $isi->L006_30)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_31 + $isi->L002_31 + $isi->L003_31 + $isi->L004_31 + $isi->L005_31 + $isi->L006_31)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L001_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L002_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L003_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L004_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L005_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L006_TIME) . "</td>";
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Work Center</strong></th>
                                        <th colspan="217" style="text-align:center;">Date (Min)</th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 001 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 002 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 003 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 004 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 005 (m) </strong></th>
                                        <th rowspan="3" style="vertical-align: middle;"><strong>Total 006 (m) </strong></th>
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
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#E34234;color:white;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:#007FFF;color:white;'>$a</td>";
                                                    } else {
                                                        echo "<td class='td-fixed' colspan='7' style='text-align:center;background:whitesmoke;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>

                                    <?php 
                                        for ($x = 1; $x <= 31; $x++) {
                                            echo "<td style='text-align:center;background:whitesmoke;'>001</td>";
                                            echo "<td style='text-align:center;background:whitesmoke;'>002</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>003</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>004</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>005</td>"; 
                                            echo "<td style='text-align:center;background:whitesmoke;'>006</td>";
                                            echo "<td style='text-align:center;background:#5FFA6F;'>Total</td>"; 
                                        }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_downtime as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;><strong>$isi->CHR_WORK_CENTER</strong></td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_01) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_01 + $isi->L002_01 + $isi->L003_01 + $isi->L004_01 + $isi->L005_01 + $isi->L006_01)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_02) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_02 + $isi->L002_02 + $isi->L003_02 + $isi->L004_02 + $isi->L005_02 + $isi->L006_02)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_03) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_03 + $isi->L002_03 + $isi->L003_03 + $isi->L004_03 + $isi->L005_03 + $isi->L006_03)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_04) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_04 + $isi->L002_04 + $isi->L003_04 + $isi->L004_04 + $isi->L005_04 + $isi->L006_04)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_05) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_05 + $isi->L002_05 + $isi->L003_05 + $isi->L004_05 + $isi->L005_05 + $isi->L006_05)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_06) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_06 + $isi->L002_06 + $isi->L003_06 + $isi->L004_06 + $isi->L005_06 + $isi->L006_06)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_07) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_07 + $isi->L002_07 + $isi->L003_07 + $isi->L004_07 + $isi->L005_07 + $isi->L006_07)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_08) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_08 + $isi->L002_08 + $isi->L003_08 + $isi->L004_08 + $isi->L005_08 + $isi->L006_08)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_09) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_09 + $isi->L002_09 + $isi->L003_09 + $isi->L004_09 + $isi->L005_09 + $isi->L006_09)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_10) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_10 + $isi->L002_10 + $isi->L003_10 + $isi->L004_10 + $isi->L005_10 + $isi->L006_10)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_11) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_11 + $isi->L002_11 + $isi->L003_11 + $isi->L004_11 + $isi->L005_11 + $isi->L006_11)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_12) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_12 + $isi->L002_12 + $isi->L003_12 + $isi->L004_12 + $isi->L005_12 + $isi->L006_12)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_13) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_13 + $isi->L002_13 + $isi->L003_13 + $isi->L004_13 + $isi->L005_13 + $isi->L006_13)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_14) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_14 + $isi->L002_14 + $isi->L003_14 + $isi->L004_14 + $isi->L005_14 + $isi->L006_14)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_15) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_15 + $isi->L002_15 + $isi->L003_15 + $isi->L004_15 + $isi->L005_15 + $isi->L006_15)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_16) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_16 + $isi->L002_16 + $isi->L003_16 + $isi->L004_16 + $isi->L005_16 + $isi->L006_16)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_17) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_17 + $isi->L002_17 + $isi->L003_17 + $isi->L004_17 + $isi->L005_17 + $isi->L006_17)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_18) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_18 + $isi->L002_18 + $isi->L003_18 + $isi->L004_18 + $isi->L005_18 + $isi->L006_18)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_19) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_19 + $isi->L002_19 + $isi->L003_19 + $isi->L004_19 + $isi->L005_19 + $isi->L006_19)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_20) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_20 + $isi->L002_20 + $isi->L003_20 + $isi->L004_20 + $isi->L005_20 + $isi->L006_20)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_21) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_21 + $isi->L002_21 + $isi->L003_21 + $isi->L004_21 + $isi->L005_21 + $isi->L006_21)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_22) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_22 + $isi->L002_22 + $isi->L003_22 + $isi->L004_22 + $isi->L005_22 + $isi->L006_22)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_23) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_23 + $isi->L002_23 + $isi->L003_23 + $isi->L004_23 + $isi->L005_23 + $isi->L006_23)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_24) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_24 + $isi->L002_24 + $isi->L003_24 + $isi->L004_24 + $isi->L005_24 + $isi->L006_24)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_25) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_25 + $isi->L002_25 + $isi->L003_25 + $isi->L004_25 + $isi->L005_25 + $isi->L006_25)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_26) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_26 + $isi->L002_26 + $isi->L003_26 + $isi->L004_26 + $isi->L005_26 + $isi->L006_26)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_27) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_27 + $isi->L002_27 + $isi->L003_27 + $isi->L004_27 + $isi->L005_27 + $isi->L006_27)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_28) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_28 + $isi->L002_28 + $isi->L003_28 + $isi->L004_28 + $isi->L005_28 + $isi->L006_28)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_29) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_29 + $isi->L002_29 + $isi->L003_29 + $isi->L004_29 + $isi->L005_29 + $isi->L006_29)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_30) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_30 + $isi->L002_30 + $isi->L003_30 + $isi->L004_30 + $isi->L005_30 + $isi->L006_30)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L001_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L002_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L003_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L004_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L005_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->L006_31) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;background:#5FFA6F;'>" . str_replace('.',',',($isi->L001_31 + $isi->L002_31 + $isi->L003_31 + $isi->L004_31 + $isi->L005_31 + $isi->L006_31)) . "</td>";

                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L001_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L002_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L003_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L004_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L005_TIME) . "</td>";
                                        echo "<td class='td-fixed' style='text-align:center;'>" . str_replace('.',',',$isi->TOTAL_L006_TIME) . "</td>";
                                        
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
                                                            leftColumns: 2
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();

                                                     var table2 = $('#example2').DataTable({
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

                                                    table2.on('order.dt search.dt', function () {
                                                        table2.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();

                                                });

</script>