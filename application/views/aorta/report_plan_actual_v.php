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
                        <div class="pull-right grid-tools">
                            <!-- <?php echo form_open('aorta/report_plan_actual_c/export_ot_plan_actual', 'class="form-horizontal"'); ?>
                                <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                                <input name="CHR_DEPT_SELECTED" value="<?php echo $id_dept ?>" type="hidden">
                                <input name="CHR_SECTION_SELECTED" value="<?php echo $id_section ?>" type="hidden">
                                <input name="CHR_SUBSECTION_SELECTED" value="<?php echo $id_subsect ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?> -->
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'  >
                                <tr>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 0; $x++) {  $y = $x * 28 ?>
                                                <option value="<?PHP echo site_url('aorta/report_plan_actual_c/index/' . date("Ym", strtotime("+$y day")) . "/$id_dept/$id_section/$id_subsect"); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        
                                        <?php if ($role == 5 || $role == 39 || $role == 45 || $role == 62 || $role == 6) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;"  onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php } else { ?>
                                                <select  onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <?php } ?>
                                                <?php foreach ($all_dept as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/report_plan_actual_c/index/" . $selected_date . '/' . $row->INT_ID_DEPT . "/ALL/ALL"); ?>" <?php
                                                    if ($id_dept == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td width="10%">
                                        <select  onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <option value="<?php echo site_url('aorta/report_plan_actual_c/index/' . $selected_date . "/$id_dept/ALL/ALL") ?>">ALL</option>
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_plan_actual_c/index/' . $selected_date . "/$id_dept/" . trim($row->KODE) . "/ALL"); ?>" 
                                                <?php
                                                if (trim($id_section) == trim($row->KODE)) {
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
                                        <!-- <th rowspan="2" style="vertical-align: middle;">No</th> -->
                                        <th rowspan="2" style="vertical-align: middle;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;">Name</th>
                                        <!-- <th rowspan="2" style="vertical-align: middle;">Section</th> -->
                                        <!-- <th rowspan="2" style="vertical-align: middle;">Sub Section </br>(Line)</th> -->
                                        <th rowspan="2" style="vertical-align: middle;">OT</th>
                                        <?php 
                                            $tot_days = date("t", strtotime($selected_date . "01"));
                                        ?>
                                        <th colspan="<?php echo $tot_days; ?>" style="vertical-align: middle;text-align:center;">Date</th>
                                        <th rowspan="2" style="vertical-align: middle;">Total</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        $aortadb = $this->load->database("aorta", TRUE);
                                        for ($index = 1; $index < ($tot_days + 1); $index++) {
                                            $day = sprintf("%02d", $index);
                                            $date = $selected_date . $day;
                                            $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                            if ($holiday == 0) {
                                                ?>
                                                <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" ><?php echo $index; ?></th>
                                                <?php
                                            } else {
                                                ?>
                                                <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px; color: #ffffff; background-color: #DD0000" ><?php echo $index; ?></th>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        foreach($all_karyawan as $kry){
                                            echo "<tr>";
                                            // echo "<td rowspan='2' style='vertical-align: middle;'>$no</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$kry->NPK</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;'>$kry->NAMA</td>";
                                            // echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$kry->KD_SECTION</td>";
                                            // echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$kry->KD_SUB_SECTION</td>";
                                            echo "<td>PLAN</td>";
                                            
                                            $tot_renc = 0;
                                            for ($index = 1; $index < ($tot_days + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $ot = $aortadb->query("SELECT RENC_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE NPK = '$kry->NPK' AND TGL_OVERTIME = '$date'")->row();
                                                if(count($ot) != 0){
                                                    $tot_renc = $tot_renc + number_format($ot->RENC_DURASI_OV_TIME/60,2,'.',',');
                                                    echo "<td style='vertical-align: middle;text-align:center;'>" . number_format($ot->RENC_DURASI_OV_TIME/60,2,'.',',') . "</td>";
                                                } else {
                                                    echo "<td style='vertical-align: middle;text-align:center;'>0</td>";
                                                }
                                            }
                                            
                                            echo "<td style='vertical-align: middle;text-align:center;'><strong>$tot_renc</strong></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            // echo "<td rowspan='' style='vertical-align: middle; display: none;'>$no</td>";
                                            echo "<td rowspan='' style='vertical-align: middle; display: none;'>$kry->NPK</td>";
                                            echo "<td rowspan='' style='vertical-align: middle; display: none;'>$kry->NAMA</td>";
                                            // echo "<td rowspan='' style='vertical-align: middle; display: none;'>$kry->KD_SECTION</td>";
                                            // echo "<td rowspan='' style='vertical-align: middle; display: none;'>$kry->KD_SUB_SECTION</td>";
                                            echo "<td>ACT</td>";
                                            
                                            $tot_real = 0;
                                            for ($index = 1; $index < ($tot_days + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $ot = $aortadb->query("SELECT REAL_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE NPK = '$kry->NPK' AND TGL_OVERTIME = '$date'")->row();
                                                if(count($ot) != 0){
                                                    $tot_real = $tot_real + number_format($ot->REAL_DURASI_OV_TIME/60,2,'.',',');
                                                    echo "<td style='vertical-align: middle;text-align:center;'>" . number_format($ot->REAL_DURASI_OV_TIME/60,2,'.',',') . "</td>";
                                                } else {
                                                    echo "<td style='vertical-align: middle;text-align:center;'>0</td>";
                                                }
                                            }
                                            
                                            echo "<td style='vertical-align: middle;text-align:center;'><strong>$tot_real</strong></td>";
                                            echo "</tr>";
                                            
                                            $no++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <table id="exportToExcel" class="table table-striped table-bordered table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle;">Section</th>
                                        <th rowspan="2" style="vertical-align: middle;">Sub Section</th>
                                        <th rowspan="2" style="vertical-align: middle;">OT</th>
                                        <?php 
                                            $tot_days = date("t", strtotime($selected_date . "01"));
                                        ?>
                                        <th colspan="<?php echo $tot_days; ?>" style="vertical-align: middle;text-align:center;">Date</th>
                                        <th rowspan="2" style="vertical-align: middle;">Total</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        $aortadb = $this->load->database("aorta", TRUE);
                                        for ($index = 1; $index < ($tot_days + 1); $index++) {
                                            $day = sprintf("%02d", $index);
                                            $date = $selected_date . $day;
                                            $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                                            if ($holiday == 0) {
                                                ?>
                                                <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px;" ><?php echo $index; ?></th>
                                                <?php
                                            } else {
                                                ?>
                                                <th style="vertical-align: middle;text-align:center;table-layout: fixed;min-width:30px; color: #ffffff; background-color: #DD0000" ><?php echo $index; ?></th>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        foreach($all_karyawan as $kry){
                                            echo "<tr>";
                                            echo "<td rowspan='2' style='vertical-align: middle;'>$no</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$kry->NPK</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;'>$kry->NAMA</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$kry->KD_SECTION</td>";
                                            echo "<td rowspan='2' style='vertical-align: middle;text-align:center;'>$kry->KD_SUB_SECTION</td>";
                                            echo "<td>PLAN</td>";
                                            
                                            $tot_renc = 0;
                                            for ($index = 1; $index < ($tot_days + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $ot = $aortadb->query("SELECT RENC_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE NPK = '$kry->NPK' AND TGL_OVERTIME = '$date'")->row();
                                                if(count($ot) != 0){
                                                    $tot_renc = $tot_renc + number_format($ot->RENC_DURASI_OV_TIME/60,2,'.',',');
                                                    echo "<td style='vertical-align: middle;text-align:center;'>" . number_format($ot->RENC_DURASI_OV_TIME/60,2,'.',',') . "</td>";
                                                } else {
                                                    echo "<td style='vertical-align: middle;text-align:center;'>0</td>";
                                                }
                                            }
                                            
                                            echo "<td style='vertical-align: middle;text-align:center;'><strong>$tot_renc</strong></td>";
                                            echo "</tr>";

                                            echo "<tr>";
                                            // echo "<td rowspan='' style='vertical-align: middle;'>$no</td>";
                                            // echo "<td rowspan='' style='vertical-align: middle;'>$kry->NPK</td>";
                                            // echo "<td rowspan='' style='vertical-align: middle;'>$kry->NAMA</td>";
                                            // echo "<td rowspan='' style='vertical-align: middle;'>$kry->KD_SECTION</td>";
                                            // echo "<td rowspan='' style='vertical-align: middle;'>$kry->KD_SUB_SECTION</td>";
                                            echo "<td>ACT</td>";
                                            
                                            $tot_real = 0;
                                            for ($index = 1; $index < ($tot_days + 1); $index++) {
                                                $day = sprintf("%02d", $index);
                                                $date = $selected_date . $day;
                                                $ot = $aortadb->query("SELECT REAL_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE NPK = '$kry->NPK' AND TGL_OVERTIME = '$date'")->row();
                                                if(count($ot) != 0){
                                                    $tot_real = $tot_real + number_format($ot->REAL_DURASI_OV_TIME/60,2,'.',',');
                                                    echo "<td style='vertical-align: middle;text-align:center;'>" . number_format($ot->REAL_DURASI_OV_TIME/60,2,'.',',') . "</td>";
                                                } else {
                                                    echo "<td style='vertical-align: middle;text-align:center;'>0</td>";
                                                }
                                            }
                                            
                                            echo "<td style='vertical-align: middle;text-align:center;'><strong>$tot_real</strong></td>";
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

