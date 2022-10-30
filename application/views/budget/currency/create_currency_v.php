
<script type="text/javascript">
    
        $("#btn_cancel").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/budget/currency_c/cancel_create",
                data: {INT_ID_DEPT: $(this).val()}, type: "POST",
                success: function(data) {
                    $("#3rd_panel").html(data);
                }
            });
    });
</script>

<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>CURRENCY</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/currency_c/save_currency', 'class="form-horizontal"'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Currency Code</label>
            <div class="col-sm-8">
                <input name="CHR_CURRENCY" autofocus class="form-control" maxlength="3" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Currency Desc</label>
            <div class="col-sm-8">
                <input name="CHR_CURRENCY_DESC" class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Currency Value</label>
            <div class="col-sm-8">
                <input name="NUM_IDR_CURRENCY" class="form-control" required type="number">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    <a href="#"id="btn_cancel" class="btn btn-default"> Cancel</a>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>

</div>