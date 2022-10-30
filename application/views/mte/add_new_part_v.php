<script type="text/javascript">    
    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/mte/preventive_schedule_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });
</script>

<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">ADD <strong>NEW PART</strong> PREVENTIVE</span>
    </div>
    <div class="grid-body">
        <?php echo form_open('mte/preventive_schedule_c/save', 'class="form-horizontal"'); ?>
        <input name="GROUP_LINE" class="form-control" type="hidden" value="<?php echo $group_line; ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">Part Code <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="CHR_PART_CODE" autofocus class="form-control" maxlength="15" required type="text" style="width: 80px;text-transform: uppercase;">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Part Name <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="CHR_PART_NAME" class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Model <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="CHR_MODEL" autofocus class="form-control" maxlength="20" required type="text" style="width: 200px;text-transform: uppercase;">
            </div>
        </div>
        <?php if($group_line == '4' || $group_line == '7' || $group_line == '8'){ ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Schedule Prev <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <select name="INT_TYPE_PREV" class="form-control" style="width:100px">
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">12 Months</option>
                </select>
            </div>
        </div>
        <?php } else { ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Std Stroke Prev <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="INT_STROKE" autofocus class="form-control" required type="number" style="width: 100px;">
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-8 col-sm-push-4">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                    <a href="#"id="btn_cancel" class="btn btn-default"> Cancel</a>
                    <?php 
                        // echo anchor('mte/preventive_schedule_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                        echo form_close();
                    ?>
                </div>
            </div>
        </div>
        <font style="color: red; font-weight: bold">* Required Field</font>
    </div>
</div>