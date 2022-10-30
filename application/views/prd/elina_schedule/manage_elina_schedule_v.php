<script>
    $(document).ready(function () {
        var table = $('#dataTables1').DataTable({
            processing: true
        });

        $('#btn_refresh').on('click', function () {
            $(".dataTables_processing").show();
            setTimeout(function () {

                table.draw();
                $(".dataTables_processing").hide();
            }, 1000);
        });

    });
</script>
<style type="text/css">
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
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
    input[type=checkbox].css-checkbox {
        position:absolute; z-index:-1000; left:-1000px; overflow: hidden; clip: rect(0 0 0 0); 
        height:1px; width:1px; margin:-1px; padding:0; border:0;
    }

    input[type=checkbox].css-checkbox + label.css-label {
        padding-left:30px;
        height:25px; 
        display:inline-block;
        line-height:25px;
        background-repeat:no-repeat;
        background-position: 0 0;
        font-size:12px;
        vertical-align:middle;
        cursor:pointer;
    }

    input[type=checkbox].css-checkbox:checked + label.css-label {
        background-position: 0 -25px;
    }
    label.css-label {
        background-image:url(http://csscheckbox.com/checkboxes/u/csscheckbox_391ce065f36b1460c4845fa9b5173fba.png);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/prd/elina_schedule_c/"') ?>"><strong>Manage Schedule ELINA</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>MASTER SCHEDULE ELINA ORDER</strong></span>
<!--                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/pes/part_per_line_c/prepare_data_part_line/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload target Production" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Upload Target</a>
                        </div>-->
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 10px;">
                        <div class="pull">
                            <?php echo form_open('prd/elina_schedule_c/search_by', 'class="form-horizontal"'); ?> 
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">
                                        <input type="checkbox" value="DL" name="DL" id="checkboxDL" <?php echo $checkboxDL; ?> class="css-checkbox" /> 
                                        <label for="checkboxDL" class="css-label">Door Lock (DL)</label>
                                    </td>
                                    <td width="10%">
                                        <input type="checkbox" value="BP" name="BP" id="checkboxBP" <?php echo $checkboxBP; ?> class="css-checkbox" /> 
                                        <label for="checkboxBP" class="css-label">Body Part (BP)</label>
                                    </td>
                                    <td width="5%">
                                        <input type="checkbox" value="CC" name="CC" id="checkboxCC" <?php echo $checkboxCC; ?> class="css-checkbox" /> 
                                        <label for="checkboxCC" class="css-label">CC</label>
                                    </td>
                                    <td width="5%">
                                        <input type="checkbox" value="CD" name="CD" id="checkboxCD" <?php echo $checkboxCD; ?> class="css-checkbox" /> 
                                        <label for="checkboxCD" class="css-label">CD</label>
                                    </td>
                                    <td width="15%">
                                        <input type="checkbox" value="ST" name="ST" id="checkboxST" <?php echo $checkboxST; ?> class="css-checkbox" /> 
                                        <label for="checkboxST" class="css-label">Stamping (ST)</label>
                                    </td>
                                    <td width="15%">
                                        <input type="checkbox" value="IN" name="IN" id="checkboxIN" <?php echo $checkboxIN; ?> class="css-checkbox" /> 
                                        <label for="checkboxIN" class="css-label">Injection (IN)</label>
                                    </td>
                                    <td width="20%">
                                    </td>
                                <tr>
                                <tr>
                                    <td width="20%">

                                        <button type="submit" name="btn_submit" id="btn_submit" value="1" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Search" style="height:30px;width:100px;"><i class="fa fa-search"></i>&nbsp;&nbsp;Filter</button>
                                        <?php echo form_close(); ?></td>
                                    <td width="20%">
                                    </td>
                                    <td width="20%">
                                    </td>
                                    <td width="20%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                        <!-- <a href="<?php echo base_url('index.php/pes/part_per_line_c/prepare_data_part_line/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload Part Per Line" style="height:30px;font-size:13px;width:120px;"><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp;Upload Excel</a> -->
                                    </td>
                                    <td width="10%">
                                        <a href="<?php echo base_url('index.php/prd/elina_schedule_c/new_data/"') ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Buat Data Baru" style="height:30px;font-size:13px;width:120px;"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Tambah Data</a>
                                    </td>
                                <tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>

                    </div >

                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>Area</th>
                                        <th style='text-align:center;'>Time Order</th>
                                        <th style='text-align:center;'>Function</th>
                                        <th style='text-align:center;'>Status Delete</th>
                                        <th style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($dt_schedule as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_AREA</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_TIME_EXEC</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_FUNCTION</td>";
                                        if($isi->CHR_FLAG_DELETE=='T'){ ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/check1.png" ?>" width="25"></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><img src="<?php echo base_url() . "/assets/img/error1.png" ?>" width="25"></td>
                                        <?php }
                                        ?>
                                    <td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/prd/elina_schedule_c/edit_schedule') . "/" . $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit Status Aktif"><span class="fa fa-pencil"></span></a>
                                        <!--<a href="<?php echo base_url('index.php/pes/part_per_line_c/delete_target_production') . "/" . $isi->CHR_PART_NO . "/" . $isi->CHR_BACK_NO; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this data?');"><span class="fa fa-times"></span></a>-->
                                    </td>
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                        $(document).ready(function () {
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

                                        document.getElementById("uploadBtn").onchange = function () {
                                            document.getElementById("uploadFile").value = this.value;
                                        };
</script>