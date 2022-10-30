
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>PRODUCT</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('budget/product_c/update_product', 'class="form-horizontal"'); ?>

            <div hidden class="form-group">
                <label class="col-sm-4 control-label">Id Product</label>
                <div class="col-sm-8">
                    <input name="INT_ID_PRODUCT" value="<?php echo trim($product->INT_ID_PRODUCT); ?> "class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Product Code</label>
                <div class="col-sm-8">
                    <input name="CHR_PRODUCT" value="<?php echo trim($product->CHR_PRODUCT); ?> " autofocus class="form-control" maxlength="3" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Product Name</label>
                <div class="col-sm-8">
                    <input name="CHR_PRODUCT_DESC" value="<?php echo trim($product->CHR_PRODUCT_DESC); ?> " class="form-control" maxlength="30" required type="text">
                </div>
            </div>
            
            
            
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php echo anchor('budget/product_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div></div>