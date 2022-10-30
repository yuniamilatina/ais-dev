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
            <li><a href="<?php echo base_url('index.php/pes/target_production_c/"') ?>">Manage Target Production</a></li>
            <li class="active"> <a href="#"><strong>Upload Target Production</strong></a></li>
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
                        <i class="fa fa-upload"></i>
                        <span class="grid-title"><strong>UPLOAD TARGET PRODUCTION</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-bottom: 0px;padding-top: 25px;">
                        <?php echo form_open('pes/target_production_c/download_template_target_production', 'class="form-horizontal"');
                        ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Template</label>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-warning"  name="btn-download" value="1"><i class="fa fa-download"></i>&nbsp; Download</button>
                            </div>

                            <?php echo form_close(); ?>
                            <?php echo form_open_multipart('pes/target_production_c/upload_target_production', 'class="form-horizontal"'); ?>


                            <label class="col-sm-3"><input type="file" name="upload_packing" class="form-control" id="import" size="20" value=""> </label>
                            <div class="col-sm-4">
                                <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-refresh"></i> Processing Data</button>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                        <?php echo form_open('pes/target_production_c/merge_target_production', 'class="form-horizontal"'); ?>

                    </div >

                    <div class="grid-body" style="padding-top: 0px">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Period</th>
                                        <th>Work Center</th>
                                        <th>Σ CT(s)</th>
                                        <th>MH/PC</th>
                                        <th>PC/MH</th>
                                        <th>Plan MP (SWS)</th>
                                        <th>Qty/Jam (SWS)</th>
                                        <th>Qty/Jam (GEDS)</th>
                                        <th>Jumlah MP (GEDS)</th>
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
                                        echo "<td style='text-align:center;'>$isi->INT_CT</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_MH_PC</td>";
                                        echo "<td style='text-align:center;'>$isi->CHR_PC_MH</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_PLAN_MP1</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_QTY_PER_JAM_SWS</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_QTY_PER_JAM_GEDS</td>";
                                        echo "<td style='text-align:center;'>$isi->INT_PLAN_MP2</td>";
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-offset-10">
                            <?php if ($exists == 1) { ?>
                                <button type="submit" name="submit" class="btn btn-success" value="1"  data-toggle="tooltip" data-placement="right" title="Save this data" onclick='return confirm("Apakah anda yakin data sudah sesuai?")'><i class="fa fa-save"></i>&nbsp; Save</button>
                            <?php } else { ?>
                                <button type="submit" name="submit" disabled class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Upload this data"><i class="fa fa-save"></i>&nbsp; Save</button>
                            <?php } ?>

                            <?php echo form_close(); ?>
                            <a href="<?php echo base_url('index.php/pes/target_production_c/reset') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
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