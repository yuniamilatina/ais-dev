<script type="text/javascript">

    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/budget/product_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });
</script>

<div id="3rd_panel" class="grid"><div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>PRODUCT</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open('budget/product_c/save_product', 'class="form-horizontal"'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Product Code</label>
            <div class="col-sm-8">
                <input name="CHR_PRODUCT" autofocus class="form-control" maxlength="3" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Product Name</label>
            <div class="col-sm-8">
                <input name="CHR_PRODUCT_DESC" class="form-control" maxlength="30" required type="text">
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