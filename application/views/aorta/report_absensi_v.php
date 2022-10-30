<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>
<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });
   
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
        width: 100px;
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
            <li><a href=""><strong>REPORT ABSENSI OVERTIME</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title">REPORT <strong>ABSENSI</strong> OVERTIME</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('aorta/report_absensi_c/export_absensi', 'class="form-horizontal"'); ?>
                                <input name="CHR_MONTH_SELECTED" value="<?php echo $periode; ?>" type="hidden">
                                <input name="CHR_DAY_SELECTED" value="<?php echo $day; ?>" type="hidden">
                                <input name="CHR_DEPT_SELECTED" value="<?php echo $id_dept; ?>" type="hidden">
                                <input name="CHR_SECTION_SELECTED" value="<?php echo $id_section; ?>" type="hidden">
                                <input name="CHR_SUBSECTION_SELECTED" value="<?php echo $id_subsect; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Date</td>
                                    <td width="25%">
                                        <select id="opt_wcenter" class="ddl2" style="width:60px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = 1; $x < 32; $x++) { ?>
                                                <option value="<?php echo site_url('aorta/report_absensi_c/index/' . $periode . '/' . sprintf("%02d", $x) . "/$id_dept/$id_section/$id_subsect"); ?>" <?php
                                                if ($day == sprintf("%02d", $x)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo sprintf("%02d", $x); ?> </option>
                                                    <?php } ?>
                                        </select>
                                        <select id="opt_wcenter" class="ddl2" style="width:116px;" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<?PHP echo site_url('aorta/report_absensi_c/index/' . date("Ym", strtotime("+$x month")) . "/$day/$id_dept/$id_section/$id_subsect"); ?>" <?php
                                                if ($periode == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>                                        
                                    </td>
                                    <td>Section</td>
                                    <td>
                                        <select id="section" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/report_absensi_c/index/' . $periode . "/$day/$id_dept/ALL/ALL") ?>">ALL</option>
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_absensi_c/index/' . $selected_date . "/$day/$id_dept/" . trim($row->KODE) . "/ALL"); ?>" 
                                                <?php
                                                if (trim($id_section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="25%">
                                        <?php if ($npk == '0483' || $npk == '0483a'){ ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                            <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                        <?php } else { ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                        <?php if ($role == 5 || $role == 39 || $role == 45 || $role == 62 || $role == 6) { ?>
                                            <select disabled style="cursor:not-allowed;background-color: #F3F4F5;" id="dept" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php } else { ?>
                                                <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                                <?php } ?>
                                        <?php } ?> <!-- ADDITIONAL TASK FORCE OVERTIME -->
                                                    <option value=""> -- Select Dept -- </option>
                                                <?php foreach ($all_dept as $row) { ?>
                                                    <option value="<?php echo site_url("aorta/report_absensi_c/index/" . $selected_date . "/$day/" . $row->INT_ID_DEPT . "/ALL/ALL"); ?>" <?php
                                                    if ($id_dept == $row->INT_ID_DEPT) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?> ><?php echo trim($row->CHR_DEPT) . " - " . trim($row->CHR_DEPT_DESC); ?></option>
                                                        <?php } ?>
                                            </select>
                                    </td>
                                    <td>Sub Section</td>
                                    <td>
                                        <select id="subsect" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <option value="<?php echo site_url('aorta/report_absensi_c/index/' . $selected_date . "/$day/$id_dept/$id_section/ALL") ?>">ALL</option>
                                            <?php foreach ($all_lines as $row) { ?>
                                                <option value="<?php echo site_url('aorta/report_absensi_c/index/' . $selected_date . "/$day/$id_dept/$id_section/$row->KODE"); ?>" 
                                                <?php
                                                if (trim($id_subsect) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> >
                                                    <?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%"></td>
                                    <td width="25%"></td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%" >
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Dept</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Section</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Sub Section </br>(Line)</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Hari Kerja</th> 
                                        <th colspan="2" style="vertical-align: middle;text-align: center; text-align: center;">Jam</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle;text-align: center;">Masuk</th>
                                        <th style="vertical-align: middle;text-align: center;">Pulang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        foreach($absensi_ot as $ot){
                                            echo "<tr>";
                                            echo "<td>$no</td>";
                                            echo "<td style='text-align: center;'>$ot->NPK</td>";
                                            echo "<td style='text-align: center;'>$ot->NAMA</td>";
                                            echo "<td style='text-align: center;'>$ot->KD_DEPT</td>";
                                            echo "<td style='text-align: center;'>$ot->KD_SECTION</td>";
                                            echo "<td style='text-align: center;'>$ot->KD_SUB_SECTION</td>";
                                            if($ot->HARI_KJ == 1){
                                                echo "<td style='text-align: center;'>LIBUR</td>";                                                
                                            } else {
                                                echo "<td style='text-align: center;'>NORMAL</td>";
                                            }
                                            echo "<td style='text-align: center;'>". date('H:i:s', strtotime($ot->JAM_MASUK)) ."</td>";
                                            echo "<td style='text-align: center;'>". date('H:i:s', strtotime($ot->JAM_PULANG)) ."</td>";
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
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });
    });
    
</script>

