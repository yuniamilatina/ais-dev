<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 30);
</script>

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
    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 120px;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT OVERTIME PLAN VS ACTUAL</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT OVERTIME PLAN VS ACTUAL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'  >
                                <tr>
                                    <td width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 0; $x++) {  $y = $x * 28 ?>
                                                <option value="<?PHP echo site_url('aorta/report_overtime_c/plan_vs_actual/' . date("Ym", strtotime("+$y day")) . "/$dept/$section"); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php foreach ($all_dept as $row) { ?>
                                            <option value="<?php echo site_url("aorta/report_overtime_c/plan_vs_actual/" . $period . '/' . trim($row->CHR_DEPT) . "/ALL"); ?>" <?php
                                            if ($dept == trim($row->CHR_DEPT)) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <option value="<?php echo site_url('aorta/report_overtime_c/plan_vs_actual/' . $period . "/$dept/ALL") ?>">ALL</option>
                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_overtime_c/plan_vs_actual/' . $period . "/".trim($dept)."/" . trim($row->KODE)); ?>" 
                                                <?php
                                                if (trim($section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style='text-align:right'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'OT-plan-vs-actual')" value="Export to Excel" style="margin-bottom: 0px;">    
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" >
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="text-align: center;">NPK</th>
                                        <th rowspan="2" style="text-align: center;">Name</th>
                                        <th rowspan="2" style="text-align: center;">OT</th>
                                        <th colspan="31" style="text-align: center;">Date</th>
                                        <th rowspan="2" style="text-align: center;">Total</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        for ($index = 1; $index <= 31; $index++) { ?>
                                            <th style="text-align:center;table-layout: fixed;min-width:30px;" ><?php echo $index; ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $flag_same = null;
                                        foreach($data as $row){
                                            echo "<tr>";
                                            // if($flag_same != $row->NPK){
                                                echo "<td rowspan='1' style='text-align: center;'>$row->NPK</td>";
                                                echo "<td rowspan='1' style='text-align: center;'>$row->NAMA</td>";
                                            //     $flag_same = $row->NPK;
                                            // }
                                            echo "<td style='text-align:center;'>$row->OT</td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_01)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_02)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_03)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_04)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_05)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_06)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_07)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_08)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_09)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_10)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_11)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_12)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_13)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_14)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_15)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_16)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_17)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_18)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_19)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_20)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_21)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_22)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_23)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_24)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_25)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_26)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_27)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_28)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_29)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_30)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_31)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->TOTAL)."</strong></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <table id="exportToExcel" class="table table-striped table-bordered table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="text-align: center;">NPK</th>
                                        <th rowspan="2" style="text-align: center;">Name</th>
                                        <th rowspan="2" style="text-align: center;">OT</th>
                                        <th colspan="31" style="text-align: center;">Date</th>
                                        <th rowspan="2" style="text-align: center;">Total</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        for ($index = 1; $index <= 31; $index++) { ?>
                                            <th style="text-align:center;table-layout: fixed;min-width:30px;" ><?php echo $index; ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $flag_same = null;
                                        foreach($data as $row){
                                            echo "<tr>";
                                            // if($flag_same != $row->NPK){
                                                echo "<td rowspan='1' style='text-align: center;'>'$row->NPK</td>";
                                                echo "<td rowspan='1' style='text-align: center;'>$row->NAMA</td>";
                                            //     $flag_same = $row->NPK;
                                            // }
                                            echo "<td style='text-align:center;'>$row->OT</td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_01)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_02)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_03)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_04)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_05)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_06)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_07)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_08)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_09)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_10)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_11)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_12)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_13)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_14)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_15)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_16)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_17)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_18)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_19)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_20)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_21)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_22)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_23)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_24)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_25)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_26)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_27)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_28)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_29)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_30)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->DATE_31)."</strong></td>";
                                            echo "<td style='text-align:center;'><strong>".str_replace('.',',',$row->TOTAL)."</strong></td>";
                                            echo "</tr>";
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
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
</script>

