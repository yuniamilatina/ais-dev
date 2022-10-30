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

<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>FISCAL</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/fiscal_c/save_fiscal', 'class="form-horizontal"'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Fiscal Year</label>
            <div class="col-sm-8">
                <input name="FISCAL_YEAR" autofocus class="form-control" maxlength="9" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Fiscal Year Start</label>
            <div class="col-sm-8">
                <input name="START" class="form-control" maxlength="4" required type="number">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Month Start</label>
            <div class="col-sm-8">
                <input name="M_START" class="form-control" maxlength="2" required type="number">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Fiscal Year End</label>
            <div class="col-sm-8">
                <input name="END" class="form-control" maxlength="4" required type="number">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Month End</label>
            <div class="col-sm-8">
                <input name="M_END" class="form-control" maxlength="2" required type="number">
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <a href="#"id="btn_cancel" class="btn btn-default"> Cancel</a>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>