<script type="text/javascript">
    
        $("#btn_cancel").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/fiscal_c/cancel_create",
                success: function(data) {
                    $("#3rd_panel").html(data);
                }
            });
    });
</script>
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>FISCAL</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('budget/fiscal_c/update_fiscal', 'class="form-horizontal"'); ?>

            <div hidden class="form-group">
                <label class="col-sm-4 control-label">Id Fiscal Year</label>
                <div class="col-sm-8">
                    <input name="ID_FISCAL_YEAR" value="<?php echo $fiscal->INT_ID_FISCAL_YEAR; ?> "class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Fiscal Year</label>
                <div class="col-sm-8">
                    <input name="FISCAL_YEAR" value="<?php echo trim($fiscal->CHR_FISCAL_YEAR); ?> " autofocus class="form-control" maxlength="9" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Fiscal Year Start</label>
                <div class="col-sm-8">
                    <input name="START" placeholder="<?php echo $fiscal->CHR_FISCAL_YEAR_START; ?> " value="" class="form-control" maxlength="4" required type="number">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Month Start</label>
                <div class="col-sm-8">
                    <input name="M_START" placeholder="<?php echo $fiscal->CHR_MONTH_START; ?> " value="" class="form-control" maxlength="2" required type="number">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Fiscal Year End</label>
                <div class="col-sm-8">
                    <input name="END" placeholder="<?php echo $fiscal->CHR_FISCAL_YEAR_END; ?> " value="" class="form-control" maxlength="4" required type="number">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Month</label>
                <div class="col-sm-8">
                    <input name="M_END" placeholder="<?php echo $fiscal->CHR_MONTH_END; ?> " value="" class="form-control" maxlength="2" required type="number">
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php echo anchor('budget/fiscal_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
               
            </div>
            <?php echo form_close(); ?>
        </div></div> </div>