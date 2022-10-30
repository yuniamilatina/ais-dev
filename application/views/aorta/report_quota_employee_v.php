<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
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
        /* border-spacing: 10px; */
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
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

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT QUOTA EMPLOYEE</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT QUOTA EMPLOYEE</strong> </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?PHP echo site_url('aorta/report_quota_employee_c/index/' . date("Ym", strtotime("+$y day")) . "/$dept/$section"); ?>" <?php
                                                                                                                                                                                        if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>> <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<?php echo site_url("aorta/report_quota_employee_c/index/" . $period . '/' . $row->CHR_DEPT . "/ALL"); ?>" <?php
                                                                                                                                                                            if ($dept == $row->CHR_DEPT) {
                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                            }
                                                                                                                                                                            ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('aorta/report_quota_employee_c/index/' . $period . "/$dept/ALL") ?>">ALL</option>
                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_quota_employee_c/index/' . $period . "/$dept/" . trim($row->KODE)); ?>" <?php
                                                                                                                                                                            if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                            }
                                                                                                                                                                            ?>>
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style='text-align:right'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Quota-Employee')" value="Export to Excel" style="margin-bottom: 0px;">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Section</th>
                                        <th colspan="3" style="border-left: solid 1px #DDDDDD;text-align:center;">Kuota Produksi</th>
                                        <th colspan="3" style="border-left: solid 1px #DDDDDD;border-right: solid 1px #DDDDDD;text-align:center;">Kuota Improvement</th>
                                        <th colspan="3" style="border-right: solid 1px #DDDDDD;text-align:center;">Sisa Kuota</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center;border-left: solid 1px #DDDDDD;">Plan</th>
                                        <th style="text-align:center;">Aktual</th>
                                        <th style="text-align:center;">Sisa</th>
                                        <th style="text-align:center;border-left: solid 1px #DDDDDD;">Plan</th>
                                        <th style="text-align:center;">Aktual</th>
                                        <th style="text-align:center;">Sisa</th>
                                        <th style="text-align:center;border-left: solid 1px #DDDDDD;">Plan</th>
                                        <th style="text-align:center;">Aktual</th>
                                        <th style="text-align:center;border-right: solid 1px #DDDDDD;">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr>";
                                        echo "<td style='text-align:center;'>$no</td>";
                                        echo "<td style='text-align:center;'>$isi->NPK</td>";
                                        echo "<td style='text-align:left;'>$isi->NAMA</td>";
                                        echo "<td style='text-align:center;'>$isi->KD_SECTION</td>";

                                        echo "<td style='text-align:center;border-left: solid 1px #DDDDDD;'>$isi->QUOTAPLAN</td>";
                                        echo "<td style='text-align:center;'>$isi->TERPAKAIPLAN</td>";
                                        echo "<td style='text-align:center;border-right: solid 1px #DDDDDD;'>$isi->SISAPLAN</td>";

                                        echo "<td style='text-align:center;'>$isi->QUOTAPLAN1</td>";
                                        echo "<td style='text-align:center;'>$isi->TERPAKAIPLAN1</td>";
                                        echo "<td style='text-align:center;border-right: solid 1px #DDDDDD;'>$isi->SISAPLAN1</td>";

                                        echo "<td style='text-align:center;'>$isi->TOT_QUOTAPLAN</td>";
                                        echo "<td style='text-align:center;'>$isi->TOT_TERPAKAIPLAN</td>";
                                        echo "<td style='text-align:center;border-right: solid 1px #DDDDDD;'>$isi->TOT_SISAPLAN</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <table id="exportToExcel" class="table table-striped table-bordered table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Section<br>Sub Section</th>
                                        <th colspan="65" style="vertical-align: middle;text-align:center;">Quota</th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;">Realization</th>
                                        <th colspan="3" style="vertical-align: middle;text-align:center;">Remain</th>
                                    </tr>
                                    <tr>
                                        <?php for ($x = 1; $x < 32; $x++) { ?>
                                            <th style="text-align:center;table-layout: fixed;min-width:30px;"><?php echo $x; ?></th>
                                        <?php } ?>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Prod.</th>
                                        <?php for ($x = 1; $x < 32; $x++) { ?>
                                            <th style="text-align:center;table-layout: fixed;min-width:30px;"><?php echo $x; ?></th>
                                        <?php } ?>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Impv.</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Total</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Impv.</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Prod.</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Total</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Impv.</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Prod.</th>
                                        <th style="text-align:center;table-layout: fixed;min-width:30px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr>";
                                        echo "<td style='text-align:center;'>$no</td>";
                                        echo "<td style='text-align:center;'>$isi->NPK</td>";
                                        echo "<td style='text-align:left;'>$isi->NAMA</td>";
                                        echo "<td style='text-align:center;'>$isi->KD_SECTION/$isi->KD_SUB_SECTION</td>";

                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_1, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_2, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_3, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_4, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_5, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_6, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_7, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_8, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_9, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_10, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_11, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_12, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_13, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_14, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_15, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_16, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_17, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_18, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_19, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_20, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_21, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_22, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_23, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_24, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_25, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_26, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_27, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_28, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_29, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_30, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_31, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center;'>$isi->QUOTAPLAN</td>";

                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_1, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_2, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_3, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_4, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_5, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_6, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_7, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_8, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_9, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_10, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_11, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_12, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_13, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_14, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_15, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_16, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_17, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_18, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_19, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_20, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_21, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_22, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_23, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_24, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_25, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_26, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_27, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_28, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_29, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_30, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_31, 2, ',', '.') . "</td>";
                                        echo "<td style='text-align:center;'>$isi->QUOTAPLAN1</td>";

                                        echo "<td style='text-align:center;font-weight: bold;'>$isi->TOT_QUOTAPLAN</td>";
                                        echo "<td style='text-align:center;'>$isi->TERPAKAIPLAN</td>";
                                        echo "<td style='text-align:center;'>$isi->TERPAKAIPLAN1</td>";
                                        echo "<td style='text-align:center;font-weight: bold;'>$isi->TOT_TERPAKAIPLAN</td>";
                                        echo "<td style='text-align:center;'>$isi->SISAPLAN</td>";
                                        echo "<td style='text-align:center;'>$isi->SISAPLAN1</td>";
                                        echo "<td style='text-align:center;font-weight: bold;'>$isi->TOT_SISAPLAN</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY QUOTA THIS PERIODE - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='300px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_section/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL QUOTA OT PER MONTH - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='250px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
