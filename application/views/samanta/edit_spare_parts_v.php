<aside class="right-side">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-gear"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT</strong> SPARE PART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>                    
                    <div class="grid-body">
                    <?php echo form_open_multipart('samanta/spare_parts_c/update_sp', 'class="form-horizontal"'); ?>                        
                        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">
                        <input name="CHR_PART_NO" class="form-control" type="hidden" value="<?php echo $data->CHR_PART_NO; ?>">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Spare Part No</label>
                            <div class="col-sm-3">
                                <input name="CHR_PART_NO" autofocus class="form-control" maxlength="15" type="text" autocomplete="off" required value="<?php echo trim($data->CHR_PART_NO); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Spare Part Name</label>
                            <div class="col-sm-3">
                                <input name="CHR_SPARE_PART_NAME" class="form-control" maxlength="30" required type="text" autocomplete="off" value="<?php echo trim($data->CHR_SPARE_PART_NAME); ?>">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Model</label>
                            <div class="col-sm-3">
                                <input name="CHR_MODEL" class="form-control" maxlength="30" type="text" autocomplete="off" value="<?php echo trim($data->CHR_MODEL); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Back No</label>
                            <div class="col-sm-3">
                                <input name="CHR_BACK_NO" class="form-control" maxlength="30" type="text" autocomplete="off" value="<?php echo trim($data->CHR_BACK_NO); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Specification</label>
                            <div class="col-sm-3">
                                <input name="CHR_SPECIFICATION" class="form-control" maxlength="50" required type="text" autocomplete="off" value="<?php echo trim($data->CHR_SPECIFICATION); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Qty Use</label>
                            <div class="col-sm-1">
                                <input name="INT_QTY_USE" class="form-control" required type="number" autocomplete="off" value="<?php echo trim($data->INT_QTY_USE); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Qty Minimum</label>
                            <div class="col-sm-1">
                                <input name="INT_QTY_MIN" class="form-control" required type="number" autocomplete="off" value="<?php echo trim($data->INT_QTY_MIN); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Qty Maximum</label>
                            <div class="col-sm-1">
                                <input name="INT_QTY_MAX" class="form-control" required type="number" autocomplete="off" value="<?php echo trim($data->INT_QTY_MAX); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Price (Rp)</label>
                            <div class="col-sm-2">
                                <input name="CHR_PRICE" class="form-control" type="number" autocomplete="off" required value="<?php echo trim($data->CHR_PRICE); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Image</label>
                            <div class="col-sm-4">                        
                                <input name="CHR_FILENAME" id="upload" type="file"> 
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                
                                <?php
                                echo anchor('samanta/spare_parts_c/', 'Cancel', 'class="btn btn-default"');
                                ?>
                            </div>
                        </div>

                    <?php echo form_close(); ?>
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
