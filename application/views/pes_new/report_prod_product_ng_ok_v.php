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
    }, 15);
//    setInterval(function(){ alert("Hello"); }, 3000);
//    setInterval(document.getElementById("hide-sub-menus").click(), 3000));


</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT PRODUCTION PRODUCT</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION PRODUCT </strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-10px;">
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <!-- <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/' . date("Ym", strtotime("+$x month")) . '/' . $id_prod); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> 
                                                </option>
                                                    <?php } ?> -->

                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201804' . '/' . $id_prod); ?>" <?php if ($selected_date == '201804') { echo 'SELECTED'; } ?> > 201804 </option>
                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201805' . '/' . $id_prod); ?>" <?php if ($selected_date == '201805') { echo 'SELECTED'; } ?> > 201805 </option>
                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201806' . '/' . $id_prod); ?>" <?php if ($selected_date == '201806') { echo 'SELECTED'; } ?> > 201806 </option>
                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201807' . '/' . $id_prod); ?>" <?php if ($selected_date == '201807') { echo 'SELECTED'; } ?> > 201807 </option>
                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201808' . '/' . $id_prod); ?>" <?php if ($selected_date == '201808') { echo 'SELECTED'; } ?> > 201808 </option>
                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201809' . '/' . $id_prod); ?>" <?php if ($selected_date == '201809') { echo 'SELECTED'; } ?> > 201809 </option>
                                            <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/201810' . '/' . $id_prod); ?>" <?php if ($selected_date == '201810') { echo 'SELECTED'; } ?> > 201810 </option>
                                        </select>
                                    </td>
                                    <td width="10%">
                                            <?php if ($role == 17 || $role == 16 || $role == 6 || $role == 5 || $role == 32 ) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept_prod as $row) { ?>
                                                    <option value="<?php echo site_url('pes_new/report_prod_product_ng_ok_c/search_prod_entry/' . $selected_date . '/' . $row->INT_ID_DEPT); ?>" <?php
                                                    if ($id_prod == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="70%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;">
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
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
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
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_productivity as $isi) {

                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 10) {

                                            if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                                if($isi->CHR_RATIO_RIL >= 0.1){
                                                    $color = 'background:#E34234;color:white;';
                                                }else{
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }else{
                                                if($isi->CHR_RATIO_RIL >= 0.5){
                                                    $color = 'background:#E34234;color:white;';
                                                }else{
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }
    
                                            if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                                if($isi->CHR_RATIO_RIL_BEFORE >= 0.1){
                                                    $color_before = 'background:#E34234;color:white;';
                                                }else{
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }else{
                                                if($isi->CHR_RATIO_RIL_BEFORE >= 0.5){
                                                    $color_before = 'background:#E34234;color:white;';
                                                }else{
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            echo "<tr style=text-align:center; >";
                                            echo "<td style=text-align:center;><strong></strong></td>";
                                            echo "<td style=text-align:center;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL ) . "</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL_BEFORE) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.',',',$isi->CHR_RATIO_AMOUNT_RIL). "</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL)) . "</strong></td>";
                                            
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_PR)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_BT)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_TR)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_SU)) . "</strong></td>";
                                            
                                            

                                            if ($isi->OK_01 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_01)). "</td>";

                                            if ($isi->OK_02 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";

                                            if ($isi->OK_03 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";

                                            if ($isi->OK_04 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";

                                            if ($isi->OK_05 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";

                                            if ($isi->OK_06 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";

                                            if ($isi->OK_07 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";

                                            if ($isi->OK_08 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";

                                            if ($isi->OK_09 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";

                                            if ($isi->OK_10 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";

                                            if ($isi->OK_11 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";

                                            if ($isi->OK_12 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";

                                            if ($isi->OK_13 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";

                                            if ($isi->OK_14 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";

                                            if ($isi->OK_15 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";

                                            if ($isi->OK_16 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";

                                            if ($isi->OK_17 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";

                                            if ($isi->OK_18 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";

                                            if ($isi->OK_19 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";

                                            if ($isi->OK_20 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";

                                            if ($isi->OK_21 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";

                                            if ($isi->OK_22 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";

                                            if ($isi->OK_23 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";

                                            if ($isi->OK_24 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";

                                            if ($isi->OK_25 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";

                                            if ($isi->OK_26 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";

                                            if ($isi->OK_27 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";

                                            if ($isi->OK_28 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";

                                            if ($isi->OK_29 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";

                                            if ($isi->OK_30 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";

                                            if ($isi->OK_31 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";

                                            
                                           ?>
                                            </tr>
                                            <?php
                                        } else if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {

                                            if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                                if($isi->CHR_RATIO_RIL >= 0.1){
                                                    $color = 'background:#C42820;color:white;';
                                                }else{
                                                    $color = 'background:#0FA819;color:white;';
                                                }
                                            }else{
                                                if($isi->CHR_RATIO_RIL >= 0.5){
                                                    $color = 'background:#C42820;color:white;';
                                                }else{
                                                    $color = 'background:#0FA819;color:white;';
                                                }
                                            }

                                            if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                                if($isi->CHR_RATIO_RIL_BEFORE >= 0.1){
                                                    $color_before = 'background:#C42820;color:white;';
                                                }else{
                                                    $color_before = 'background:#0FA819;color:white;';
                                                }
                                            }else{
                                                if($isi->CHR_RATIO_RIL_BEFORE >= 0.5){
                                                    $color_before = 'background:#C42820;color:white;';
                                                }else{
                                                    $color_before = 'background:#0FA819;color:white;';
                                                }
                                            }

                                            echo "<tr>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong></strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL ) . " %</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL_BEFORE) . " %</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace('.',',',$isi->CHR_RATIO_AMOUNT_RIL). " %</strong></td>";

                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace(',','.',number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace(',','.',number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . str_replace(',','.',number_format($isi->TOTAL)) . "</strong></td>";
                                            
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',','.',number_format($isi->TOTAL_PR)) . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',','.',number_format($isi->TOTAL_BT)) . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',','.',number_format($isi->TOTAL_TR)) . "</td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;>" . str_replace(',','.',number_format($isi->TOTAL_SU)) . "</td>";

                                            // if ($isi->OK_01 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            //}
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_01)). "</td>";

                                            // if ($isi->OK_02 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";

                                            // if ($isi->OK_03 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";

                                            // if ($isi->OK_04 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";

                                            // if ($isi->OK_05 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";

                                            // if ($isi->OK_06 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";

                                            // if ($isi->OK_07 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } 
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";

                                            // if ($isi->OK_08 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";

                                            // if ($isi->OK_09 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } 
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";

                                            // if ($isi->OK_10 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";

                                            // if ($isi->OK_11 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";

                                            // if ($isi->OK_12 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";

                                            // if ($isi->OK_13 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";

                                            // if ($isi->OK_14 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";

                                            // if ($isi->OK_15 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";

                                            // if ($isi->OK_16 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";
                                            
                                            
                                            // if ($isi->OK_17 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";
                                            
                                            
                                            // if ($isi->OK_18 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";
                                            
                                            
                                            // if ($isi->OK_19 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";
                                            
                                            
                                            // if ($isi->OK_20 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";
                                            
                                            
                                            // if ($isi->OK_21 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";
                                            
                                            
                                            // if ($isi->OK_22 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";
                                            
                                            
                                            // if ($isi->OK_23 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";
                                            
                                            
                                            // if ($isi->OK_24 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";
                                            
                                            
                                            // if ($isi->OK_25 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";
                                            
                                            
                                            // if ($isi->OK_26 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";
                                            
                                            
                                            // if ($isi->OK_27 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";
                                            
                                            
                                            // if ($isi->OK_28 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";
                                            
                                            
                                            // if ($isi->OK_29 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";
                                            
                                            
                                            // if ($isi->OK_30 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";
                                            
                                            
                                            // if ($isi->OK_31 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";
                                            
                                           
                                            ?>
                                            </tr>
                                            <?php
                                        } else {

                                            if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                                if($isi->CHR_RATIO_RIL >= 0.1){
                                                    $color = 'background:#E34234;color:white;';
                                                }else{
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }else{
                                                if($isi->CHR_RATIO_RIL >= 0.5){
                                                    $color = 'background:#E34234;color:white;';
                                                }else{
                                                    $color = 'background:#03C03C;color:white;';
                                                }
                                            }
    
                                            if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                                if($isi->CHR_RATIO_RIL_BEFORE >= 0.1){
                                                    $color_before = 'background:#E34234;color:white;';
                                                }else{
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }else{
                                                if($isi->CHR_RATIO_RIL_BEFORE >= 0.5){
                                                    $color_before = 'background:#E34234;color:white;';
                                                }else{
                                                    $color_before = 'background:#03C03C;color:white;';
                                                }
                                            }

                                            echo "<tr>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            $r++;

                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";

                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL ) . " %</strong></td>";
                                            echo "<td style=text-align:center;$color_before><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL_BEFORE) . " %</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.',',',$isi->CHR_RATIO_AMOUNT_RIL). " %</strong></td>";

                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL)) . "</strong></td>";
                                            
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_PR)) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_BT)) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_TR)) . "</td>";
                                            echo "<td style=text-align:center;>" . str_replace(',','.',number_format($isi->TOTAL_SU)) . "</td>";


                                            // if ($isi->OK_01 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_01)). "</td>";
                                            
                                            

                                            // if ($isi->OK_02 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";
                                            
                                            

                                            // if ($isi->OK_03 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";
                                            
                                            
                                            // if ($isi->OK_04 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";
                                            
                                            
                                            // if ($isi->OK_05 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";
                                            
                                            
                                            // if ($isi->OK_06 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";
                                            
                                            
                                            // if ($isi->OK_07 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            // } 
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";
                                            
                                            
                                            // if ($isi->OK_08 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";
                                            
                                            
                                            // if ($isi->OK_09 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            // } 
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";
                                            
                                            
                                            // if ($isi->OK_10 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";
                                            
                                            
                                            // if ($isi->OK_11 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";
                                            
                                            
                                            // if ($isi->OK_12 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";
                                            
                                            
                                            // if ($isi->OK_13 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";
                                            
                                            
                                            // if ($isi->OK_14 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";
                                            
                                            
                                            // if ($isi->OK_15 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";
                                            
                                            
                                            // if ($isi->OK_16 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";
                                            
                                            
                                            // if ($isi->OK_17 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";
                                            
                                            
                                            // if ($isi->OK_18 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";
                                            
                                            
                                            // if ($isi->OK_19 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";
                                            
                                            
                                            // if ($isi->OK_20 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";
                                            
                                            
                                            // if ($isi->OK_21 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";
                                            
                                            
                                            // if ($isi->OK_22 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";
                                            
                                            
                                            // if ($isi->OK_23 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";
                                            
                                            
                                            // if ($isi->OK_24 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";
                                            
                                            
                                            // if ($isi->OK_25 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";
                                            
                                            
                                            // if ($isi->OK_26 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";
                                            
                                            
                                            // if ($isi->OK_27 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";
                                            
                                            
                                            // if ($isi->OK_28 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";
                                            
                                            // if ($isi->OK_29 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";
                                            
                                            // if ($isi->OK_30 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";
                                            
                                            
                                            // if ($isi->OK_31 >= 100) {
                                            //     echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                            //     echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            // }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";
                                            
                                            
                                            ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%"  style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">No</th>
                                        <th rowspan="3" style="vertical-align: middle;">Line</th>
                                        <th colspan='62' style="text-align:center;">Date </th>
                                        <th rowspan="3" style="vertical-align: middle;">Total OK</th>
                                        <th colspan='4' style="text-align:center;">Detail RIL </th>

                                        <th rowspan="3" style="vertical-align: middle;">Total RIL</th>
                                        <th rowspan="3" style="vertical-align: middle;">Grand Total</th>
                                        <th colspan='3' style="text-align:center;">Ratio RIL</th>
                                        
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
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                        <th rowspan='2' style="text-align: center;">Process</th>
                                        <th rowspan='2' style="text-align: center;">B.test</th>
                                        <th rowspan='2' style="text-align: center;">Trial</th>
                                        <th rowspan='2' style="text-align: center;">Setup</th>

                                        <th rowspan="2" style="text-align: center;">Qty YTD</th>
                                        <th rowspan="2" style="text-align: center;">Qty (n-1)</th>
                                        <th rowspan="2" style="text-align: center;">Amount</th>

                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 62; $x++) {
                                            if ($x % 2 != 0) {
                                                echo "<td style='text-align:center;background:#03C03C;color:white;border-left-width: 0.1em;'><div class='td-fixed'>OK</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#E34234;color:white;border-right-width: 0;'><div class='td-fixed'>NG</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <?php
                                    $r = 1;
                                    foreach ($data_productivity as $isi) {

                                        
                                        if(substr(trim($isi->CHR_WORK_CENTER),0,2) == 'AS'){
                                            if($isi->CHR_RATIO_RIL >= 0.1){
                                                $color = 'background:red;color:white;';
                                            }else{
                                                $color = 'background:green;color:white;';
                                            }
                                        }else{
                                            if($isi->CHR_RATIO_RIL >= 0.5){
                                                $color = 'background:red;color:white;';
                                            }else{
                                                $color = 'background:green;color:white;';
                                            }
                                        }

                                        if (strlen(trim($isi->CHR_WORK_CENTER)) == 7) {
                                            echo "<tr style=text-align:center;background:#A9A9A9;color:#fff; >";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong></strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            if ($isi->OK_01 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_01)). "</td>";

                                            if ($isi->OK_02 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";

                                            if ($isi->OK_03 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";

                                            if ($isi->OK_04 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#A9A9A9;color:#fff;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";

                                            if ($isi->OK_05 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";

                                            if ($isi->OK_06 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";

                                            if ($isi->OK_07 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";

                                            if ($isi->OK_08 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";

                                            if ($isi->OK_09 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";

                                            if ($isi->OK_10 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";

                                            if ($isi->OK_11 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";

                                            if ($isi->OK_12 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";

                                            if ($isi->OK_13 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";

                                            if ($isi->OK_14 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";

                                            if ($isi->OK_15 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";

                                            if ($isi->OK_16 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";

                                            if ($isi->OK_17 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";

                                            if ($isi->OK_18 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";

                                            if ($isi->OK_19 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";

                                            if ($isi->OK_20 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";

                                            if ($isi->OK_21 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";

                                            if ($isi->OK_22 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";

                                            if ($isi->OK_23 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";

                                            if ($isi->OK_24 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";

                                            if ($isi->OK_25 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";

                                            if ($isi->OK_26 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";

                                            if ($isi->OK_27 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";

                                            if ($isi->OK_28 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";

                                            if ($isi->OK_29 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";

                                            if ($isi->OK_30 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";

                                            if ($isi->OK_31 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#A9A9A9;color:#fff;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";

                                            
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_PR)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_BT)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_TR)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_SU)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL)) . "</strong></td>";
                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL ) . "</strong></td>";
                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL_BEFORE) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace('.',',',$isi->CHR_RATIO_AMOUNT_RIL). "</strong></td>";
                                            ?>
                                            </tr>
                                            <?php
                                        } else if (strlen(trim($isi->CHR_WORK_CENTER)) == 12) {
                                            echo "<tr>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong></strong></td>";
                                            echo "<td style=text-align:center;background:#DFDFDF;><strong>" . $isi->CHR_WORK_CENTER . "</strong></td>";

                                            if ($isi->OK_01 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_01)). "</td>";

                                            if ($isi->OK_02 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";

                                            if ($isi->OK_03 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";

                                            if ($isi->OK_04 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#DFDFDF;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";

                                            if ($isi->OK_05 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";

                                            if ($isi->OK_06 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";

                                            if ($isi->OK_07 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";

                                            if ($isi->OK_08 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";

                                            if ($isi->OK_09 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";

                                            if ($isi->OK_10 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";

                                            if ($isi->OK_11 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";

                                            if ($isi->OK_12 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";

                                            if ($isi->OK_13 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";

                                            if ($isi->OK_14 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";

                                            if ($isi->OK_15 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";

                                            if ($isi->OK_16 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";
                                            
                                            
                                            if ($isi->OK_17 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";
                                            
                                            
                                            if ($isi->OK_18 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";
                                            
                                            
                                            if ($isi->OK_19 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";
                                            
                                            
                                            if ($isi->OK_20 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";
                                            
                                            
                                            if ($isi->OK_21 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";
                                            
                                            
                                            if ($isi->OK_22 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";
                                            
                                            
                                            if ($isi->OK_23 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";
                                            
                                            
                                            if ($isi->OK_24 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";
                                            
                                            
                                            if ($isi->OK_25 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";
                                            
                                            
                                            if ($isi->OK_26 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";
                                            
                                            
                                            if ($isi->OK_27 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";
                                            
                                            
                                            if ($isi->OK_28 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";
                                            
                                            
                                            if ($isi->OK_29 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";
                                            
                                            
                                            if ($isi->OK_30 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";
                                            
                                            
                                            if ($isi->OK_31 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            }
                                            echo "<td style='text-align:center;background:#DFDFDF;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";
                                            
                                            
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_PR)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_BT)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_TR)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_SU)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace(',','.',number_format($isi->TOTAL)) . "</strong></td>";
                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL ) . "</strong></td>";
                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL_BEFORE) . "</strong></td>";
                                            echo "<td style=text-align:center;background:#A9A9A9;color:#fff;><strong>" . str_replace('.',',',$isi->CHR_RATIO_AMOUNT_RIL). "</strong></td>";

                                            ?>
                                            </tr>
                                            <?php
                                        } else {
                                            echo "<tr>";
                                            echo "<td style=text-align:center;>$r</td>";
                                            $r++;

                                            echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                            if ($isi->OK_01 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else if ($isi->OK_01 < 100 && $isi->OK_01 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_01)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_01)). "</td>";
                                            
                                            

                                            if ($isi->OK_02 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else if ($isi->OK_02 < 100 && $isi->OK_02 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_02)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_02)). "</td>";
                                            
                                            

                                            if ($isi->OK_03 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else if ($isi->OK_03 < 100 && $isi->OK_03 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_03)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_03)). "</td>";
                                            
                                            
                                            if ($isi->OK_04 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else if ($isi->OK_04 < 100 && $isi->OK_04 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_04)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_04)). "</td>";
                                            
                                            
                                            if ($isi->OK_05 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else if ($isi->OK_05 < 100 && $isi->OK_05 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_05)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_05)). "</td>";
                                            
                                            
                                            if ($isi->OK_06 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else if ($isi->OK_06 < 100 && $isi->OK_06 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_06)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_06)). "</td>";
                                            
                                            
                                            if ($isi->OK_07 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else if ($isi->OK_07 < 100 && $isi->OK_07 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_07)). "</td>";
                                            } echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_07)). "</td>";
                                            
                                            
                                            if ($isi->OK_08 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else if ($isi->OK_08 < 100 && $isi->OK_08 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_08)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_08)). "</td>";
                                            
                                            
                                            if ($isi->OK_09 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else if ($isi->OK_09 < 100 && $isi->OK_09 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_09)). "</td>";
                                            } echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_09)). "</td>";
                                            
                                            
                                            if ($isi->OK_10 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else if ($isi->OK_10 < 100 && $isi->OK_10 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_10)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_10)). "</td>";
                                            
                                            
                                            if ($isi->OK_11 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else if ($isi->OK_11 < 100 && $isi->OK_11 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_11)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_11)). "</td>";
                                            
                                            
                                            if ($isi->OK_12 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else if ($isi->OK_12 < 100 && $isi->OK_12 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_12)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_12)). "</td>";
                                            
                                            
                                            if ($isi->OK_13 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else if ($isi->OK_13 < 100 && $isi->OK_13 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_13)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_13)). "</td>";
                                            
                                            
                                            if ($isi->OK_14 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else if ($isi->OK_14 < 100 && $isi->OK_14 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_14)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_14)). "</td>";
                                            
                                            
                                            if ($isi->OK_15 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else if ($isi->OK_15 < 100 && $isi->OK_15 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_15)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_15)). "</td>";
                                            
                                            
                                            if ($isi->OK_16 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else if ($isi->OK_16 < 100 && $isi->OK_16 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_16)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_16)). "</td>";
                                            
                                            
                                            if ($isi->OK_17 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else if ($isi->OK_17 < 100 && $isi->OK_17 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_17)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_17)). "</td>";
                                            
                                            
                                            if ($isi->OK_18 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else if ($isi->OK_18 < 100 && $isi->OK_18 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_18)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_18)). "</td>";
                                            
                                            
                                            if ($isi->OK_19 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else if ($isi->OK_19 < 100 && $isi->OK_19 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_19)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_19)). "</td>";
                                            
                                            
                                            if ($isi->OK_20 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else if ($isi->OK_20 < 100 && $isi->OK_20 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_20)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_20)). "</td>";
                                            
                                            
                                            if ($isi->OK_21 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else if ($isi->OK_21 < 100 && $isi->OK_21 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_21)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_21)). "</td>";
                                            
                                            
                                            if ($isi->OK_22 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else if ($isi->OK_22 < 100 && $isi->OK_22 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_22)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_22)). "</td>";
                                            
                                            
                                            if ($isi->OK_23 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else if ($isi->OK_23 < 100 && $isi->OK_23 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_23)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_23)). "</td>";
                                            
                                            
                                            if ($isi->OK_24 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else if ($isi->OK_24 < 100 && $isi->OK_24 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_24)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_24)). "</td>";
                                            
                                            
                                            if ($isi->OK_25 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else if ($isi->OK_25 < 100 && $isi->OK_25 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_25)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_25)). "</td>";
                                            
                                            
                                            if ($isi->OK_26 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else if ($isi->OK_26 < 100 && $isi->OK_26 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_26)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_26)). "</td>";
                                            
                                            
                                            if ($isi->OK_27 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else if ($isi->OK_27 < 100 && $isi->OK_27 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_27)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_27)). "</td>";
                                            
                                            
                                            if ($isi->OK_28 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else if ($isi->OK_28 < 100 && $isi->OK_28 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_28)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_28)). "</td>";
                                            
                                            
                                            if ($isi->OK_29 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else if ($isi->OK_29 < 100 && $isi->OK_29 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_29)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_29)). "</td>";
                                            
                                            
                                            if ($isi->OK_30 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else if ($isi->OK_30 < 100 && $isi->OK_30 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_30)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_30)). "</td>";
                                            
                                            
                                            if ($isi->OK_31 >= 100) {
                                                echo "<td style='text-align:center;background:#03C03C;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else if ($isi->OK_31 < 100 && $isi->OK_31 > 0) {
                                                echo "<td style='text-align:center;background:#FFA812;border-left-width: 0.1em;border-right-width: 0;color:white;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            } else {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;border-right-width: 0;'>" . str_replace(',','.',number_format($isi->OK_31)). "</td>";
                                            }
                                            echo "<td style='text-align:center;'>" . str_replace(',','.',number_format($isi->NG_31)). "</td>";
                                            
                                            
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_OK)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_PR)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_BT)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_TR)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_SU)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL_NG)) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace(',','.',number_format($isi->TOTAL)) . "</strong></td>";
                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL ) . "</strong></td>";
                                            echo "<td style=text-align:center;$color><strong>" . str_replace('.',',',$isi->CHR_RATIO_RIL_BEFORE) . "</strong></td>";
                                            echo "<td style=text-align:center;><strong>" . str_replace('.',',',$isi->CHR_RATIO_AMOUNT_RIL). "</strong></td>";

                                            ?>
                                            </tr>
                                            <?php
                                        }
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
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 4
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                });

</script>