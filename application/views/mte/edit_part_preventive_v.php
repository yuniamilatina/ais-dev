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
        <span class="grid-title"><strong>EDIT PART</strong> PREVENTIVE</span>
    </div>
    <div class="grid-body">
        <?php echo form_open('mte/preventive_schedule_c/update', 'class="form-horizontal"'); ?>
        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $id; ?>">
        <input name="GROUP_LINE" class="form-control" type="hidden" value="<?php echo $group_line; ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">Part Code <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="CHR_PART_CODE" required maxlength="15" class="form-control" type="text" style="width: 80px;text-transform: uppercase;" value="<?php echo $part->CHR_PART_CODE; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Part Name <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="CHR_PART_NAME" class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;"  value="<?php echo $part->CHR_PART_NAME; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Model <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="CHR_MODEL" class="form-control" maxlength="20" required type="text" style="width: 200px;text-transform: uppercase;"  value="<?php echo $part->CHR_MODEL; ?>">
            </div>
        </div>
        <?php if($group_line == '4'){ ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Schedule Prev <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <select name="INT_TYPE_PREV" class="form-control" style="width:100px">
                    <option value="3" <?php if($part->FLG_TYPE_PREV == '3'){ echo "selected";} ?>>3 Months</option>
                    <option value="6" <?php if($part->FLG_TYPE_PREV == '6'){ echo "selected";} ?>>6 Months</option>
                    <option value="12" <?php if($part->FLG_TYPE_PREV == '12'){ echo "selected";} ?>>12 Months</option>
                </select>
            </div>
        </div>
        <?php } else { ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Std Stroke Prev <font style="color:red;">*</font></label>
            <div class="col-sm-8">
                <input name="INT_STROKE" autofocus class="form-control" required type="number" style="width: 100px;" value="<?php echo $part->INT_STROKE_SMALL_PREVENTIVE; ?>">
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-8 col-sm-push-4">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data"><i class="fa fa-check"></i> Update</button>
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