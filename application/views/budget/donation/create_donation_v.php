<script type="text/javascript">

    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/budget/donation_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });
</script>

<div id="3rd_panel" class="grid"><div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>DONATION</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/donation_c/save_donation', 'class="form-horizontal"'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Donation</label>
            <div class="col-sm-8">
                <input name="CHR_DONATION" autofocus class="form-control" maxlength="5" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Donation Desc</label>
            <div class="col-sm-8">
                <input name="CHR_DONATION_DESC" class="form-control" maxlength="50" required type="text">
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