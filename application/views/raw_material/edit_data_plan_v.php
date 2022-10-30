<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">HOME</a></li>
            <li><a href="<?php echo base_url('index.php/quality/inspec_plan_c/') ?>">Master Data Inspection Plan</a></li>
            <li> <a href="#"><strong>UPDATE DATA INSPECTION PLAN</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        echo form_open_multipart('quality/inspec_plan_c/update_plan', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">UPDATE DATA INSPECTION PLAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_DOC_ID" class="form-control" type="hidden" value="<?php echo $data->CHR_DOC_ID; ?>">
                        <input name="CHR_INSPEC" class="form-control" type="hidden" value="<?php echo $data->CHR_INSPEC_TYPE; ?>">
                        <input name="CHR_DRAW" class="form-control" type="hidden" value="<?php echo $data->CHR_DRAWING_LOC; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">DOC ID</label>
                            <div class="col-sm-3">
                                <input name="CHR_DOC_ID" id="CHR_DOC_ID" class="form-control" type="text" value="<?php echo $data->CHR_DOC_ID; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Inspection Type</label>
                            <div class="col-sm-3">
                                <input name="CHR_INSPEC" id="CHR_INSPEC" class="form-control" type="text" value="<?php echo $data->CHR_INSPEC_TYPE; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-2">
                                <!-- <input name="CHR_WORK_CTR" id="CHR_WORK_CTR" class="form-control" type="text" value="<?php echo $data->CHR_WORK_CTR; ?>" readonly> -->
                                <select name="CHR_LINE" id="e2" class="form-control">
                                    <?php
                                    foreach ($data_line as $list) {
                                        if (trim($data->CHR_WORK_CTR) == trim($list->CHR_WCENTER)) {
                                    ?>
                                            <option selected value="<?php echo $list->CHR_WCENTER; ?>"><?php echo $list->CHR_WCENTER; ?></option>
                                        <?php
                                        } else {
                                        ?><option value="<?php echo $list->CHR_WCENTER; ?>"><?php echo $list->CHR_WCENTER; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <!-- <input name="CHR_PARTNO" id="CHR_PARTNO" class="form-control" type="text" value="<?php echo $data->CHR_PARTNO; ?>" readonly> -->
                                <select name="CHR_PARTNO" class="form-control" id="e1" required>
                                    <!-- <option value="">--- Pilih Partno ---</option> -->
                                    <?php
                                    foreach ($all_part as $list) {
                                        if (trim($data->CHR_PARTNO) == trim($list->CHR_PART_NO)) {
                                    ?>
                                            <option selected value="<?php echo $list->CHR_PART_NO; ?>"><?php echo $list->CHR_PART_NO; ?> - <?php echo $list->CHR_BACK_NO; ?></option>
                                        <?php
                                        } else {
                                        ?><option value="<?php echo $list->CHR_PART_NO; ?>"><?php echo $list->CHR_PART_NO; ?> - <?php echo $list->CHR_BACK_NO; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Back Number</label>
                            <div class="col-sm-2">
                                <input name="CHR_BACKNO" id="CHR_BACKNO" class="form-control" type="text" value="<?php echo $data->CHR_BACKNO; ?>" readonly>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Name</label>
                            <div class="col-sm-4">
                                <input name="CHR_PART_NM" id="CHR_PART_NM" class="form-control" type="text" value="<?php echo $data->CHR_PART_NM; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Project Code / Model Name <font color="red">(*)</font></label>
                            <div class="col-sm-4">
                                <input name="CHR_MODEL_NM" id="CHR_MODEL_NM" class="form-control" type="text" value="<?php echo $data->CHR_MODEL_NM; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Drawing </label>
                            <div class="col-sm-4">
                                <input name="CHR_DRAWING_LOC" id="upload" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Revised Date <font color="red">(*)</font></label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input name="CHR_RV_DATE" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo date("d-M-Y", strtotime($data->CHR_REVISED_DATE)); ?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-sm-3 control-label">Status Delete(*Ganti T)</label>
                            <div class="col-sm-2">
                                <input name="CHR_STAT_DEL" id="back_no" class="form-control"  type="text" value="<?php echo $data->CHR_STAT_DEL; ?>" >
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('quality/inspec_plan_c/', 'Cancel', 'class="btn btn-default"');
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
</script>