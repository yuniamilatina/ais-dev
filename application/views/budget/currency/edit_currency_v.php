<div class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">EDIT CURRENCY</span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/currency_c/update_currency', 'class="form-horizontal"'); ?>

        <div hidden class="form-group">
            <label class="col-sm-4 control-label">Id Currency</label>
            <div class="col-sm-8">
                <input name="INT_ID_CURRENCY" value="<?php   echo trim($currency->INT_ID_CURRENCY); ?> "class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Currency Code</label>
            <div class="col-sm-8">
                <input name="CHR_CURRENCY" value="<?php echo trim($currency->CHR_CURRENCY); ?> " autofocus class="form-control" maxlength="3" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Currency Desc</label>
            <div class="col-sm-8">
                <input name="CHR_CURRENCY_DESC" value="<?php echo trim($currency->CHR_CURRENCY_DESC); ?> " class="form-control" maxlength="25" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Currency Value</label>
            <div class="col-sm-8">
                <input name="NUM_IDR_CURRENCY" value="<?php echo trim($currency->NUM_IDR_CURRENCY); ?> " class="form-control"  required type="text">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <?php echo anchor('budget/currency_c', 'Cancel', 'class="btn btn-default"'); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div></div> </div>