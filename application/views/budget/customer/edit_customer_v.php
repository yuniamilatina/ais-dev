
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>CUSTOMER</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('budget/customer_c/update_customer', 'class="form-horizontal"'); ?>

            <div hidden class="form-group">
                <label class="col-sm-4 control-label">Id Customer</label>
                <div class="col-sm-8">
                    <input name="INT_ID_CUSTOMER" value="<?php echo trim($customer->INT_ID_CUSTOMER); ?> "class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Customer</label>
                <div class="col-sm-8">
                    <input name="CHR_CUSTOMER" value="<?php echo trim($customer->CHR_CUSTOMER); ?> " autofocus class="form-control" maxlength="30" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Customer Description</label>
                <div class="col-sm-8">
                    <input name="CHR_CUSTOMER_DESC" value="<?php echo trim($customer->CHR_CUSTOMER_DESC); ?> " class="form-control" maxlength="50" required type="text">
                </div>
            </div>
            
            
            
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php echo anchor('budget/customer_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div></div>