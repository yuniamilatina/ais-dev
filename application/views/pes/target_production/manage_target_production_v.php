<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
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
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
    .fileUpload {
        position: relative;
        overflow: hidden;
        width:100px;
        margin-left: 15px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .input-upload{
        border:none;
        text-align: right;
    }
</style>


<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/target_production_c/"') ?>"><strong>Manage Target Production</strong></a></li>
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
                        <span class="grid-title"><strong>MASTER TARGET PRODUCTION</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/pes/target_production_c/prepare_upload_target_production/"') ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Upload target Production" style="height:30px;font-size:13px;width:120px;padding-left:10px;">Upload Target</a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 10px;">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Periode</td>
                                    <td width="60%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -5; $x <= 5; $x++) { ?>
                                                <option value="<? echo site_url('pes/target_production_c/search_target/' . date("Ym", strtotime("+$x month"))); ?>"<?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="15%"></td>
                                    <td width="20%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;' >No</th>
                                        <th style='text-align:center;' >Period</th>
                                        <th style='text-align:center;' >Work Center</th>
                                        <th style='text-align:center;' >TT(s)</th>
                                        <th style='text-align:center;' >Target Delivery/Day</th>
                                        <th style='text-align:center;' >Shift</th>
                                        <th style='text-align:center;' >Target/Shift</th>
                                        <th style='text-align:center;' >Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_target_production as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$r</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PERIOD</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_TT</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_TARGET_DEL</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_PLAN_SHIFT</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_TARGET_PER_SHIFT</td>";
                                        ?>
                                    <td style='text-align:center;'>
                                        <a href="<?php echo base_url('index.php/pes/target_production_c/edit_target_production') . "/" . $isi->INT_ID; ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                                        <a href="<?php echo base_url('index.php/pes/target_production_c/delete_target_production') . "/" . $isi->INT_ID; ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this target production?');"><span class="fa fa-times"></span></a>
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