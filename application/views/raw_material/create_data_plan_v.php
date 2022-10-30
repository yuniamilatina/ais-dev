<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/quality/inspec_plan_c"') ?>"><strong>Master Data Inspection Plan</strong></a></li>
            <li class="active"> <a href="#"><strong>Create New Plan</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php

        echo form_open_multipart('quality/inspec_plan_c/save_data', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE NEW PLAN</strong></span>
                        <!--<div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>-->
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Inspection Type <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <select name="CHR_INSPEC" class="form-control" required onchange="yesnoCheck(this);">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Inprocess Stage">Inprocess Stage</option>
                                    <option value="Receiving Stage">Receiving Stage</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="ifYes" style="display: none;">
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-2">
                                <select name="CHR_LINE" id="e2" class="form-control">
                                    <option value="">--- Pilih Line ---</option>
                                    <?php foreach ($data_line as $list) { ?>
                                        <option value="<?php echo trim($list->CHR_WCENTER); ?>"><?php echo trim($list->CHR_WCENTER); ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <select name="CHR_PARTNO" class="form-control" id="e1" required>
                                    <option value="">--- Pilih Partno ---</option>
                                    <?php
                                    foreach ($all_part as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_PART_NO; ?>"><?php echo $isi->CHR_PART_NO; ?> - <?php echo $isi->CHR_BACK_NO; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Project Code / Model Name <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <input type="text" name="CHR_MODEL" id="CHR_MODEL" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Drawing (<font color="red">*</font> format PNG/JPG)</label>
                            <div class="col-sm-4">
                                <input name="CHR_DRAWING_LOC" id="upload" type="file" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Execution By <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <select name="CHR_EXEC" class="form-control" required>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="Production">Production</option>
                                    <option value="Quality">Quality</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Issue Date <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input name="CHR_IS_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Revised Date <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input name="CHR_RV_DATE" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('quality/inspec_plan_c', 'Back', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>
<script type="text/javascript" language="javascript">
    $("#upload").fileinput({
        'showUpload': false
    });

    function yesnoCheck(that) {
        if (that.value == "Inprocess Stage") {
            // alert("check");
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
</script>