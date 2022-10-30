<script type="text/javascript">
    
        $("#btn_cancel").click(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/aorta/master_holiday_c/cancel_create",
                success: function(data) {
                    $("#3rd_panel").html(data);
                }
            });
    });
</script>
    <div id="3rd_panel" class="grid"><div class="grid-header">
            <i class="fa fa-calendar"></i>
            <span class="grid-title">EDIT <strong>HOLIDAY</strong></span>
        </div>
        <div class="grid-body">
            <?php echo form_open('aorta/master_holiday_c/update_holiday', 'class="form-horizontal"'); ?>

            <div hidden class="form-group">
                <label class="col-sm-4 control-label">Date</label>
                <div class="col-sm-8">
                    <input name="DATE" value="<?php echo $holiday->TGL_LIBUR; ?>" class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Description</label>
                <div class="col-sm-8">
                    <input name="DESCRIPTION" value="<?php echo trim($holiday->KETERANGAN); ?> " autofocus class="form-control" required type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Status</label>
                <div class="col-sm-8">
                    <input name="STATUS" value="<?php echo $holiday->STATUS_LB; ?>" class="form-control" maxlength="1" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Type</label>
                <div class="col-sm-8">
                    <input name="TYPE" value="<?php echo $holiday->CHR_TIPE_LB; ?>" class="form-control" maxlength="1" required>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                        <?php echo anchor('aorta/master_holiday_c', 'Cancel', 'class="btn btn-default"'); ?>
                    </div>
               
            </div>
            <?php echo form_close(); ?>
        </div></div> </div>