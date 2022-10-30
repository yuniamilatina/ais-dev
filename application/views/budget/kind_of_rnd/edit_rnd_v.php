
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>RESEARCH & DEVELOPMENT</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('budget/kind_of_rnd_c/update_rnd', 'class="form-horizontal"'); ?>

            <div hidden class="form-group">
                <label class="col-sm-4 control-label">Id RND</label>
                <div class="col-sm-8">
                    <input name="INT_ID_RND" value="<?php echo trim($rnd->INT_ID_RND); ?> "class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">RND</label>
                <div class="col-sm-8">
                    <input name="CHR_RND" value="<?php echo trim($rnd->CHR_RND); ?> " autofocus class="form-control" maxlength="5" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">RND Description</label>
                <div class="col-sm-8">
                    <input name="CHR_RND_DESC" value="<?php echo trim($rnd->CHR_RND_DESC); ?> " class="form-control" maxlength="50" required type="text">
                </div>
            </div>
            
            
            
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php echo anchor('budget/kind_of_rnd_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div></div>