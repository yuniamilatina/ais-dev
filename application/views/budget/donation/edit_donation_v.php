
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>DONATION</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('budget/donation_c/update_donation', 'class="form-horizontal"'); ?>

            <div hidden class="form-group">
                <label class="col-sm-4 control-label">Id Donation</label>
                <div class="col-sm-8">
                    <input name="INT_ID_DONATION" value="<?php echo trim($donation->INT_ID_DONATION); ?> "class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Donation</label>
                <div class="col-sm-8">
                    <input name="CHR_DONATION" value="<?php echo trim($donation->CHR_DONATION); ?> " autofocus class="form-control" maxlength="30" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Donation Desc</label>
                <div class="col-sm-8">
                    <input name="CHR_DONATION_DESC" value="<?php echo trim($donation->CHR_DONATION_DESC); ?> " class="form-control" maxlength="50" required type="text">
                </div>
            </div>
            
            
            
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php echo anchor('budget/donation_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div></div>