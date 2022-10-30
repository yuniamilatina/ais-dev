<script type="text/javascript">
    
    $("#btn_cancel").click(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/mte/master_preventive_c/cancel_create",
            success: function(data) {
                $("#3rd_panel").html(data);
            }
        });
    });

    $("#upload").fileinput({
        'showUpload': false
    });

</script>

<div id="3rd_panel" class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title">CREATE <strong>DRAWING</strong></span>
    </div>
    <div class="grid-body">
        <?php echo form_open_multipart('mte/master_preventive_c/save_drawing', 'class="form-horizontal"'); ?>

        <input name="GROUP_CODE" class="form-control" type="hidden" value="<?php echo $group_code; ?>">
        <input name="GROUP_LINE" class="form-control" type="hidden" value="<?php echo $group_line; ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">Group Type <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="GROUP_TYPE" readonly class="form-control" required type="text" value="<?php echo $group_type; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Drawing Type <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="DRAWING_TYPE" autofocus class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Drawing Name <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="DRAWING_NAME" autofocus class="form-control" required type="text">
            </div>
        </div>
        <div class="form-group" id="tool">
            <label class="col-sm-4 control-label">Part / Tooling Code <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <select name="PART_CODE" id="e1" class="form-control" required>
                    <?php
                        foreach($list_part as $part){
                            echo "<option value='". $part->INT_ID ."'>". $part->CHR_PART_CODE . " - " . $part->CHR_MODEL . " - " . $part->CHR_PART_NAME ."</>";
                        } 
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Drawing <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <input name="DRAWING" id="upload" type="file" required> 
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