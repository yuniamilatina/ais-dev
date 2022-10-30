<div class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">EDIT UoM</span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/unit_c/update_unit', 'class="form-horizontal"'); ?>

        <div hidden class="form-group">
            <label class="col-sm-4 control-label">Id UoM</label>
            <div class="col-sm-8">
                <input name="INT_ID_UNIT" value="<?php   echo trim($unit->INT_ID_SATUAN); ?> "class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">UoM</label>
            <div class="col-sm-8">
                <input name="CHR_UNIT" value="<?php echo trim($unit->CHR_SATUAN); ?> " autofocus class="form-control" maxlength="3" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">UoM Desc</label>
            <div class="col-sm-8">
                <input name="CHR_UNIT_DESC" value="<?php echo trim($unit->CHR_SATUAN_DESC); ?> " class="form-control" maxlength="25" required type="text">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <?php echo anchor('budget/unit_c', 'Cancel', 'class="btn btn-default"'); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div> 
</div>